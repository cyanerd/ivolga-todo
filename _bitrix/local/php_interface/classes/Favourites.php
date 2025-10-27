<?php
namespace Ivolga\Classes;

class Favourites
{
  /**
   * Получить список избранных товаров пользователя
   * @param int $userId ID пользователя
   * @return array Массив ID товаров
   */
  public static function getUserFavourites($userId)
  {
    if (!$userId) {
      return [];
    }

    $rsUser = \CUser::GetByID($userId);
    if ($arUser = $rsUser->Fetch()) {
      $favouritesData = $arUser['UF_FAVOURITES'];

      // Обработка разных типов данных
      if (is_array($favouritesData)) {
        // Если это массив, берем первый элемент
        $favouritesStr = isset($favouritesData[0]) ? $favouritesData[0] : '';
      } elseif (is_string($favouritesData)) {
        // Если это строка
        $favouritesStr = $favouritesData;
      } else {
        // Если null или другой тип
        $favouritesStr = '';
      }

      if (!empty($favouritesStr)) {
        // Разбираем строку с ID товаров
        $favourites = explode(',', $favouritesStr);
        return array_map('intval', array_filter($favourites));
      }
    }

    return [];
  }

  /**
   * Добавить товар в избранное
   * @param int $userId ID пользователя
   * @param int $productId ID товара
   * @return bool Успешность операции
   */
  public static function addToFavourites($userId, $productId)
  {
    if (!$userId || !$productId) {
      return false;
    }

    $favourites = self::getUserFavourites($userId);

    // Проверяем, не добавлен ли уже товар
    if (!in_array($productId, $favourites)) {
      $favourites[] = $productId;

      return self::saveUserFavourites($userId, $favourites);
    }

    return true;
  }

  /**
   * Удалить товар из избранного
   * @param int $userId ID пользователя
   * @param int $productId ID товара
   * @return bool Успешность операции
   */
  public static function removeFromFavourites($userId, $productId)
  {
    if (!$userId || !$productId) {
      return false;
    }

    $favourites = self::getUserFavourites($userId);

    // Удаляем товар из массива
    $favourites = array_filter($favourites, function ($id) use ($productId) {
      return $id != $productId;
    });

    return self::saveUserFavourites($userId, $favourites);
  }

  /**
   * Проверить, находится ли товар в избранном
   * @param int $userId ID пользователя
   * @param int $productId ID товара
   * @return bool
   */
  public static function isInFavourites($userId, $productId)
  {
    if (!$userId || !$productId) {
      return false;
    }

    $favourites = self::getUserFavourites($userId);
    return in_array($productId, $favourites);
  }

  /**
   * Сохранить список избранных товаров пользователя
   * @param int $userId ID пользователя
   * @param array $favourites Массив ID товаров
   * @return bool Успешность операции
   */
  private static function saveUserFavourites($userId, $favourites)
  {
    if (!$userId) {
      return false;
    }

    // Преобразуем массив в строку
    $favouritesStr = implode(',', $favourites);

    $user = new \CUser;
    $fields = [
      'UF_FAVOURITES' => $favouritesStr
    ];

    return $user->Update($userId, $fields);
  }

  /**
   * Синхронизировать избранное из localStorage с сервером
   * @param int $userId ID пользователя
   * @param array $localFavourites Массив ID товаров из localStorage
   * @return bool Успешность операции
   */
  public static function syncFavourites($userId, $localFavourites)
  {
    if (!$userId) {
      return false;
    }

    // Получаем текущие избранные с сервера
    $serverFavourites = self::getUserFavourites($userId);

    // Объединяем локальные и серверные избранные (удаляем дубликаты)
    $mergedFavourites = array_unique(array_merge($serverFavourites, $localFavourites));

    return self::saveUserFavourites($userId, $mergedFavourites);
  }
}

?>
