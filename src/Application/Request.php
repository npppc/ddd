<?php
namespace Npc\DDD\Application;

use Npc\Entity\Base;

class Request extends Base
{
    public $_rules = [];

    /**
     * DTO 参数数据验证 前置  =同于远端参数验证逻辑
     *
     * @param bool $safe
     * @param array $validate
     * @return array
     * @throws \Exception
     */
    public function validate($safe = true , $validate = [])
    {
        try{
            //默认验证 request->get
            !$validate && $validate = $this->_data;

            $rules = $attributes = [];
            foreach ($this->_rules as $k => $v)
            {
                if(is_string($v))
                {
                    if(stripos($v,',') !== false)
                    {
                        $rules[$k] = str_replace(',','|',$v);
                    }
                    else{
                        $rules[$k] = $v;
                    }
                }
                else if(is_array($v))
                {
                    if(stripos($v[0],',') !== false)
                    {
                        $rules[$k] = str_replace(',','|',$v[0]);
                    }
                    else
                    {
                        $rules[$k] = $v[0];
                    }
                    $attributes[$k] = $v[1];
                }
            }
            return $safe;
            return $safe ? $this->getValidator()->validate($validate,$rules,[],$attributes) : $validate;
        }
        catch (\Validation\ValidationException $e)
        {
            $errors = $e->validator->errors()->all();
            throw new \Exception('DTO参数验证错误：'.implode(',',$errors));
        }
    }

//    public function getValidator()
//    {
//        $translator = new Translator(
//            require APP_PATH.'/config/validation.php'
//        );
//        return new ValidatorFactory($translator);
//    }


    /**
     * DTO 只在像 service 传递的时候会触发
     *
     * @param bool $deep
     * @param array $columns
     * @return array
     * @throws \Exception
     */
    public function toArray($deep = false, $columns = []): array
    {
        $this->validate();

        return parent::toArray($deep, $columns); // TODO: Change the autogenerated stub
    }
}