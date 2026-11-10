<?php
// Isolated logic tests: no Bitrix bootstrap, database, HTTP or real carrier calls.
namespace Bitrix\Main {
    class Loader { public static function includeModule($id) { return true; } }
    class Application { public static $db; public static function getConnection() { return self::$db; } }
    class EventManager {
        private static $instance;
        public $handlers = [7 => ['CALLBACK' => ['CDeliveryBoxberry', 'orderCreate'], 'SORT' => 100]];
        public static function getInstance() { return self::$instance ??= new self(); }
        public function findEventHandlers(...$args) { return $this->handlers; }
        public function removeEventHandler($m, $e, $key) { unset($this->handlers[$key]); }
        public function addEventHandlerCompatible($m, $e, $callback, $file, $sort) { $this->handlers[] = ['CALLBACK' => $callback, 'SORT' => $sort]; }
        public function addEventHandler(...$args) {}
    }
}
namespace Bitrix\Main\Localization {
    class Loc { public static function loadMessages($file) {} public static function getMessage($key) {return $key;} }
}
namespace Bitrix\Sale {
    class Order {
        public static function load($id) {return new self();}
        public function getShipmentCollection() {return [new class {
            public function isSystem() {return false;}
            public function setFields($fields) {\Bitrix\Main\Application::$db->shipment=['ID'=>1];}
        }];}
        public function save() {
            $order=\Bitrix\Main\Application::$db->order;
            \Krepfield\BoxberryExport::onLegacySave($order['ID'],$order);
            \Krepfield\BoxberryExport::onSaved(new \FakeEvent($order['ID']));
        }
    }
}
namespace Bitrix\Main\Config {
    class Option {
        public static $profile = 'N';
        public static function get($module,$key,...$args) {
            if($key==='BB_PAYMENT_AS_PROFILE_TYPE')return self::$profile;
            if($key==='BB_ADD_TRACK_NUMBER_INTO_SHIPMENT')return 'Y';
            if($key==='BB_ACCOUNT_NUMBER')return 'Y';
            return 'N';
        }
    }
}
namespace Bitrix\Sale\Delivery\Services {
    class Manager {
        public static function getActiveList() { return [3 => ['ID'=>3,'CODE'=>'boxberry','PARENT_ID'=>0],6 => ['ID'=>6,'CODE'=>'boxberry:PVZ_COD','PARENT_ID'=>3],7 => ['ID'=>7,'CODE'=>'boxberry:KD_COD','PARENT_ID'=>3]]; }
    }
}
namespace {
    class Rows { private $row; public function __construct($row) {$this->row=$row;} public function fetch() {return $this->row;} }
    class FakeDb {
        public $order; public $total=100; public $transaction=0; public $shipment=false;
        public function __construct($configuration=null) {
            if($configuration!==null) {
                $source=\Bitrix\Main\Application::$db;
                $this->order=$source->order;$this->total=$source->total;$this->shipment=$source->shipment;
                if($source->transaction)$this->order['PAYED']='N';
            }
        }
        public function getConfiguration() {return ['options'=>3];}
        public function disconnect() {}
        public function query($sql) {
            if (strpos($sql,'in_transaction')!==false) return new Rows(['ACTIVE'=>$this->transaction]);
            if (strpos($sql,'b_sale_order_payment')!==false) return new Rows(['TOTAL'=>$this->total]);
            if (strpos($sql,'b_sale_order_delivery')!==false) return new Rows($this->shipment);
            return new Rows($this->order);
        }
        public function getSqlHelper() {return $this;} public function forSql($v) {return $v;}
    }
    class CBoxberryOrder {
        public static $records=[];
        public static function GetByOrderId($id) {return self::$records[$id]??false;}
        public static function Add($fields) {self::$records[$fields['ORDER_ID']]=$fields;return 1;}
        public static function Update($id,$fields){self::$records[$id]=array_replace(self::$records[$id]??[],$fields);}
    }
    class CarrierProbe {
        public static $calls=0; public static $outcome='success'; public static $payloads=[];
        public static function send($payload) {
            self::$calls++;self::$payloads[]=$payload;
            if(self::$outcome==='throw')throw new \RuntimeException('fake lost response');
            if(self::$outcome==='error')return ['err'=>'fake error'];
            return ['track'=>'TEST-'.\Bitrix\Main\Application::$db->order['ID'],'label'=>'https://invalid.test/label'];
        }
    }
    class CSaleLocation {public static function GetByID(...$args){return ['CITY_NAME'=>'Test','REGION_NAME'=>'Test','CODE'=>'TEST'];}}
    class CBoxberry {
        public static $stale=false;
        public static function GetFullOrderData($id) { $r=$GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_'.$id] ?? \Bitrix\Main\Application::$db->order; if(self::$stale)$r['PAYED']='N'; $GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_'.$id]=$r; return $r; }
        public static function getPaymentSum($price,$paid,$delivery) {return $paid==='Y'?0:$price;}
        public static function initApi() {return true;}
        public static function MakePropsArray($order) {return ['BB_LOCATION'=>1,'BB_ADDRESS'=>'Test','BB_FIO'=>'Test','BB_PHONE'=>'000','BB_EMAIL'=>'test@invalid.test','VID'=>(int)$order['DELIVERY_ID']===6?1:2];}
        public static function getReceptionPointCode() {return 'TEST';}
        public static function parselCreate($data) {return CarrierProbe::send($data);}
        public static function isSourceBoxberry() {return false;}
    }
    class CDeliveryBoxberry {
        const COURIER_DELIVERY_TYPE_ID=2;
        public static $calls=0;
        public static function getFullDimensions($items){return ['WEIGHT'=>100,'HEIGHT'=>10,'WIDTH'=>10,'LENGTH'=>10];}
        public static function getCity($code){return ['BB_COUNTRY_CODE'=>'643'];}
        public static function orderCreate($id,$fields) {self::$calls++;CBoxberryOrder::Add($fields+['ORDER_ID'=>$id]);return true;}
    }
    class StubBoxberryParsel {
        public static $calls=0; public static $outcome='success';
        public function parselCreate($id) {
            $result=CarrierProbe::send(['payment_sum'=>'0','delivery_sum'=>\Bitrix\Main\Application::$db->order['PRICE_DELIVERY']]);
            if(!isset($result['track']))return ['ERROR'=>$result['err']];
            // Reentrant save before the vendor stores its track.
            \Krepfield\BoxberryExport::onLegacySave($id,\Bitrix\Main\Application::$db->order);
            CBoxberryOrder::$records[$id]['TRACKING_CODE']='TEST-'.$id;
            return ['track'=>'TEST-'.$id];
        }
    }
    $vendorFile=getenv('BOXBERRY_VENDOR_PARCEL');
    if($vendorFile) {require $vendorFile;} else {class_alias(StubBoxberryParsel::class,'CBoxberryParsel');}
    require dirname(__DIR__).'/local/php_interface/lib/BoxberryExport.php';
    use Krepfield\BoxberryExport as Export;
    $root=sys_get_temp_dir().'/krepfield-boxberry-unit-'.bin2hex(random_bytes(6));mkdir($root);mkdir($root.'/site');
    $_SERVER['DOCUMENT_ROOT']=$root.'/site';$_SESSION=[];
    $db=new FakeDb();\Bitrix\Main\Application::$db=$db;
    $checkCount=0;
    function check($value,$message) {global $checkCount;$checkCount++;if(!$value)throw new \RuntimeException($message);}
    function enabled($value) { (new \ReflectionProperty(Export::class,'enabled'))->setValue(null,$value); }
    function order($id,$changes=[]) { global $db; $db->order=array_replace(['ID'=>$id,'LID'=>'s1','DELIVERY_ID'=>6,'PAYED'=>'Y','CANCELED'=>'N','PRICE'=>100,'CURRENCY'=>'RUB','PRICE_DELIVERY'=>25,'ACCOUNT_NUMBER'=>'TEST-'.$id,'PERSON_TYPE_ID'=>'1','PVZ_CODE'=>'TEST','ITEMS'=>[['PRODUCT_ID'=>1,'NAME'=>'Test','MEASURE_NAME'=>'pcs','VAT_RATE'=>null,'PRICE'=>75,'MEASURE_CODE'=>'796','QUANTITY'=>1]]],$changes);$db->total=100;$db->transaction=0;$db->shipment=false;return $db->order; }
    class FakeEvent {private $id;public function __construct($id){$this->id=$id;}public function getParameter($p){return $this;}public function getId(){return $this->id;}}
    function save($id) {Export::onSaved(new FakeEvent($id));Export::flush();}
    try {
        Export::register();Export::register();
        check((new \ReflectionProperty(Export::class,'enabled'))->getValue() === (require dirname(__DIR__).'/local/php_interface/boxberry-export-config.php'),'Runtime flag must match deployed configuration');
        enabled(false);
        check(count(\Bitrix\Main\EventManager::getInstance()->handlers)===1,'Vendor handler must be replaced once');
        Export::onLegacySave(1,order(1));save(1);
        check(CDeliveryBoxberry::$calls===1 && CarrierProbe::$calls===0,'Disabled flag must preserve legacy route');
        enabled(true);Export::onLegacySave(2,order(2,['PAYED'=>'N']));save(2);
        check(CDeliveryBoxberry::$calls===1 && CarrierProbe::$calls===0,'Early PD/unpaid save must not export');
        check(isset(CBoxberryOrder::$records[2]),'NEW record must be retained');
        order(2);save(2);save(2);
        check(CarrierProbe::$calls===1,'Full payment/reentrant track save/repeated callback must export once');
        order(3);$db->total=50;save(3);check(CarrierProbe::$calls===1,'Partial payment must not export');
        order(4,['CANCELED'=>'Y']);save(4);check(CarrierProbe::$calls===1,'Cancelled order must not export');
        order(5,['DELIVERY_ID'=>2]);save(5);check(CarrierProbe::$calls===1,'Other delivery must not export');
        order(6);CBoxberryOrder::$records[6]=['TRACKING_CODE'=>'EXISTING'];save(6);check(CarrierProbe::$calls===1,'Existing vendor track must block export');
        order(7);$db->shipment=['ID'=>99];save(7);check(CarrierProbe::$calls===1,'Existing shipment track must block export');
        order(8);$db->transaction=1;save(8);check(CarrierProbe::$calls===1,'Open transaction must not export');
        order(9);CBoxberry::$stale=true;save(9);CBoxberry::$stale=false;check(CarrierProbe::$calls===1,'Stale legacy snapshot must not export');
        order(10);\Bitrix\Main\Config\Option::$profile='Y';save(10);\Bitrix\Main\Config\Option::$profile='N';check(CarrierProbe::$calls===1,'Broken payment profile option must fail closed');
        order(11);CarrierProbe::$outcome='throw';save(11);save(11);
        check(CarrierProbe::$calls===2,'Lost reply must not retry');
        enabled(false);Export::onLegacySave(11,$db->order);Export::onLegacySave(2,order(2));
        check(CDeliveryBoxberry::$calls===1,'Rollback must not pass protected orders to legacy exporter');
        Export::onLegacySave(12,order(12));check(CDeliveryBoxberry::$calls===2,'Rollback must preserve legacy route for untouched orders');
        enabled(true);order(13);CarrierProbe::$outcome='error';save(13);save(13);check(CarrierProbe::$calls===3,'API error must await manual review');
        order(14);$lock=fopen($root.'/.krepfield-boxberry-export/14.lock','c');flock($lock,LOCK_EX);save(14);check(CarrierProbe::$calls===3,'Concurrent lock holder must block second export');flock($lock,LOCK_UN);fclose($lock);
        CarrierProbe::$outcome='success';order(15,['DELIVERY_ID'=>7]);save(15);check(CarrierProbe::$calls===4,'Courier profile must export');
        $state=json_decode(file_get_contents($root.'/.krepfield-boxberry-export/11.json'),true);check($state['status']==='needs_review','Lost response marker must survive request');
        file_put_contents($root.'/.krepfield-boxberry-export/16.json','broken');order(16);save(16);check(CarrierProbe::$calls===4,'Corrupt state must fail closed');
        order(17);
        $GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_17']=$db->order;
        $GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_17']['PAYED']='N';
        $GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_18']=['ID'=>18,'PAYED'=>'N'];
        save(17);
        check(CarrierProbe::$calls===5,'Committed full payment must refresh the legacy cache from an earlier unpaid save');
        check($GLOBALS['SALE_ORDER']['SALE_ORDER_CACHE_18']['PAYED']==='N','Other orders cache must remain untouched');
        foreach(CarrierProbe::$payloads as $payload) {
            check((float)$payload['payment_sum']===0.0,'Actual request must collect zero');
            check((float)$payload['delivery_sum']===25.0,'Actual request must preserve delivery price');
        }
        if($vendorFile) {
            check(CarrierProbe::$payloads[0]['vid']===1,'Actual PVZ request must select PVZ');
            check(CarrierProbe::$payloads[3]['vid']===2,'Actual courier request must select courier');
            check(CBoxberryOrder::$records[15]['TRACKING_CODE']==='TEST-15','Actual vendor method must persist track');
        }
        echo "OK: $checkCount checks; ".($vendorFile?'installed vendor parcel method':'stub parcel method')."; no external calls\n";
    } finally {
        foreach(glob($root.'/.krepfield-boxberry-export/*')?:[] as $file)unlink($file);
        @rmdir($root.'/.krepfield-boxberry-export');rmdir($root.'/site');rmdir($root);
    }
}
