<?php
namespace Bitrix\Affettapromo;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

class ClaimTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'affettapromo_claim';
    }

    public static function getUfId()
    {
        return 'AFFETTAPROMO_CLAIM';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\IntegerField('USER_ID', array(
                'required' => true,
            )),
            new Entity\StringField('NAME', array(
                'required' => true,
                'column_name' => 'USER_NAME',
            )),
            new Entity\StringField('PHONE', array(
                'required' => true,
                'column_name' => 'USER_PHONE',
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique(),
                    );
                }
            )),
            new Entity\StringField('MAIL', array(
                'required' => true,
                'column_name' => 'USER_MAIL',
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique(),
                    );
                }
            )),
            new Entity\BooleanField('CONFIRMED', array(
                'values' => array('N', 'Y'),
                'default_value' => 'N'
            )),
            new Entity\EnumField('WAY', array(
                'values' => array('OZON', 'YA'),
                'required' => true,
            )),
            new Entity\EnumField('SKILL', array(
                'values' => array('PROFI', 'AMATEUR'),
                'required' => true,
            )),
            new Entity\EnumField('POSITION', array(
                'values' => array('MONTAGE', 'ELECTR', 'SLES', 'MECH'),
            )),
            new Entity\DatetimeField('CREATE_DATE', array(
                'default_value' => function () {
                    return new Type\DateTime(date('Y-m-d h:i:s', time()), 'Y-m-d h:i:s');
                }
            )),
        );
    }

    public static function onBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");

        if (isset($data['PHONE']))
            $result->modifyFields(array('PHONE' => str_replace(array(' ','-','(',')','+'),"",$data['PHONE'])));

        if (isset($data['MAIL']))
            $result->modifyFields(array('MAIL' => str_replace(' ',"",$data['MAIL'])));

        return $result;
    }
}