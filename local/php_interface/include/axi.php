<?php

class Axi
{
  private static $sIncludePath = "include/";
  private static $sTextsPath = "texts/";
  private static $sModulesPath = "modules/";

  public static function GT($filename)
  {
    global $APPLICATION;
    $APPLICATION->IncludeComponent("bitrix:main.include", "", [
      "AREA_FILE_SHOW" => "file",
      "EDIT_MODE" => 'text',
      "PATH" => SITE_DIR . self::$sIncludePath . self::$sTextsPath . $filename . '.php',
    ]);
  }

  public static function GF($filename, $params = [])
  {
    global $APPLICATION;
    $APPLICATION->IncludeFile(
      SITE_DIR . self::$sIncludePath . self::$sModulesPath . $filename . '.php',
      $params,
      ["SHOW_BORDER" => false]
    );
  }

  private static $_instance;

  public static function get()
  {
    if (!is_object(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }
}