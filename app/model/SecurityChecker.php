<?php
namespace RockGuard\app\model;

class SecurityChecker
{
    /**
     * Get all scan results for the user
     *
     * @param int $user_id
     * @return mixed
     */
    public static function all($user_id)
    {
        $statement = $GLOBALS['conn']->prepare("SELECT `url`, `label`, `id` FROM `urls` WHERE `user_id` = ?");
        $statement->execute([$user_id]);
        return $statement->fetchAll();
    }

    /**
     * Create a new scan result
     *
     * @param string $url
     * @param int $label
     * @param int $user_id
     * @return mixed
     */
    public static function create($url, $label, $user_id)
    {
        $statement = $GLOBALS['conn']->prepare('INSERT INTO `urls` (`url`, `label`, `user_id`) VALUES (?, ?, ?)');
        return $statement->execute([$url, $label, $user_id]);
    }

    /**
     * Update a scan result for a URL
     *
     * @param int $id
     * @param string $url
     * @param int $label
     * @param int $user_id
     * @return mixed
     */
    public static function update($id, $url, $label, $user_id)
    {
        $statement = $GLOBALS['conn']->prepare("UPDATE `urls` SET `url` = :url_des, `label` = :label_des WHERE `id` = :id_des AND `user_id` = :user_id_des");
        return $statement->execute([
            'url_des' => $url,
            'label_des' => $label,
            'id_des' => $id,
            'user_id_des' => $user_id
        ]);
    }

    /**
     * Find a scan result for a URL using its ID
     *
     * @param int $id
     * @return mixed
     */
    public static function find($id)
    {
        $statement = $GLOBALS['conn']->prepare("SELECT * FROM `urls` WHERE `id` = ? AND `user_id` = ?");
        $statement->execute([$id, Auth::user()['id']]);
        return $statement->fetch();
    }

    /**
     * Find a scan result for a URL using the URL itself
     *
     * @param string $url
     * @return mixed
     */
    public static function findByUrl($url)
    {
        $statement = $GLOBALS['conn']->prepare("SELECT * FROM `urls` WHERE `url` = ? LIMIT 1");
        $statement->execute([$url]);
        return $statement->fetch(); // Return the record if it exists
    }
}
