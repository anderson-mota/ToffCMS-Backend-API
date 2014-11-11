<?php
/**
 * Created by PhpStorm.
 * User: anderson.mota
 * Date: 12/08/2014
 * Time: 10:17
 *
 * @author Anderson Mota <anderson.mota@lqdi.net>
 */

class SettingTest extends TestCase {

    public function provider()
    {
        return [
            ['Test Unit', 'Sunt fluctuses fallere magnum, azureus tataes.', 'testKey', 'X', 'X|Y|Z', 'Y']
        ];
    }

    /**
     * @dataProvider provider
     * @param $name
     * @param $description
     * @param $key
     * @param $default
     * @param $value
     * @param $available_values
     * @param $is_public
     */
    public function testBasicCreate($name, $description, $key, $default, $value, $available_values, $is_public)
    {
        $response = $this->action("POST", 'SettingController@store',
            ['name' => $name, 'description' => $description, 'key' => $key, 'default' => $default, 'value' => $value,
                'available_values' => $available_values, 'is_public' => $is_public]);
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? $content->message : null);
    }

    public function testListPublic()
    {
        $response = $this->action("GET", "SettingController@index");
        $content = json_decode($response->getContent());

        $this->assertNotError($content->error, $content->error ? $content->message : null);
    }
}
