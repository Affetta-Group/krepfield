<?php
namespace Bitrix\Affettaredirects;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class RedirectsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'affetta_redirects';
    }

    public static function getUfId()
    {
        return 'AFFETTA_REDIRECTS';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\BooleanField('ACTIVE', array(
                'required' => true,
                'column_name' => 'REDIRECT_ACTIVITY',
                'values' => array('N', 'Y'),
                'default_value' => 'Y'
            )),
            new Entity\StringField('BEFORE', array(
                'required' => true,
                'column_name' => 'LINK_BEFORE',
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique(),
                    );
                }
            )),
            new Entity\StringField('AFTER', array(
                'required' => true,
                'column_name' => 'AFTER_BEFORE',
            )),
        );
    }

    public static function onBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

        if (isset($data['BEFORE'])) {
            $data['BEFORE'] = str_replace(' ', '', $data['BEFORE']);

            if(preg_match("/".$request->getHttpHost()."/",$data['BEFORE'],$matches)){
                $data['BEFORE'] = explode($request->getHttpHost(),$data['BEFORE'])[1];
            }
        }
        if (isset($data['AFTER'])) {
            $data['AFTER'] = str_replace(' ', '', $data['AFTER']);

            if(preg_match("/".$request->getHttpHost()."/",$data['AFTER'],$matches)){
                $data['AFTER'] = explode($request->getHttpHost(),$data['AFTER'])[1];
            }
        }

        $result->modifyFields(array('BEFORE' => $data['BEFORE'], 'AFTER' => $data['AFTER']));

        return $result;
    }

    public static function OnBeforeUpdate(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

        if (isset($data['BEFORE'])) {
            $data['BEFORE'] = str_replace(' ', '', $data['BEFORE']);

            if(preg_match("/".$request->getHttpHost()."/",$data['BEFORE'],$matches)){
                $data['BEFORE'] = explode($request->getHttpHost(),$data['BEFORE'])[1];
            }
        }
        if (isset($data['AFTER'])) {
            $data['AFTER'] = str_replace(' ', '', $data['AFTER']);

            if(preg_match("/".$request->getHttpHost()."/",$data['AFTER'],$matches)){
                $data['AFTER'] = explode($request->getHttpHost(),$data['AFTER'])[1];
            }
        }

        $result->modifyFields(array('BEFORE' => $data['BEFORE'], 'AFTER' => $data['AFTER']));

        return $result;
    }
}