<?php
/**
 * Created by PhpStorm.
 * User: plotnikov
 * Date: 01.06.2017
 * Time: 17:53
 */

namespace ilyaplot\containers;

/**
 * Class Config
 * @package ilyaplot\containers
 *
 * @description
 * Читает конфиги вида
 * <?php
 * return [];
 * Производит контроль целостности конфига, его наличия, задает значения по-умолчанию.
 * Предоставляет простой объектный стиль доступа или array access к конфигу
 */
class Config extends Container
{
    /**
     * Config constructor.
     * @param $configFilename путь до файла конфигурации
     * @param array $defaultValues массив значений по-умолчанию
     * @param array $requiredParams массив обязательных ключей конфигурации
     * @param bool $isConfigRequired контроль наличия конфига.
     * @throws ContainerException
     */
    public function __construct($configFilename, array $defaultValues = [], array $requiredParams = [], $isConfigRequired = true)
    {
        $this->_attributes = $this->readConfig($configFilename, $isConfigRequired);

        // Подстановка дефолтных значений при их отсутствии
        foreach ($defaultValues as $param => $value) {
            $this->_attributes[$param] = isset($this->_attributes[$param]) ? $this->_attributes[$param] : $value;
        }

        $notFoundRequiredParams = array_diff($requiredParams, array_keys($this->_attributes));
        if (!empty(($notFoundRequiredParams))) {
            throw new ContainerException("Required param(s) \"" . implode(', ', $notFoundRequiredParams) . "\" has not been set.");
        }
    }

    /**
     * Читает конфиг из файла в массив
     * @param $configFilename
     * @return array
     * @throws ContainerException
     */
    protected function readConfig($configFilename, $isConfigRequired) //:array
    {
        if (!file_exists($configFilename) || !is_readable($configFilename)) {
            if ($isConfigRequired) {
                throw new ContainerException("Config file \"{$configFilename}\" not found.");
            } else {
                return [];
            }
        }

        try {
            $config = require $configFilename;
        } catch (\Exception $ex) {
            throw new ContainerException("Config \"{$configFilename}\" can't be load.", $ex->getCode(), $ex);
        }

        return (array)$config;
    }

}