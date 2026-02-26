<?php

use yii\db\Migration;

class m170828_175739_init extends Migration
{
    public function safeUp()
    {
        // migration (уже может существовать)
        $this->execute("CREATE TABLE IF NOT EXISTS `migration` (
          `version` varchar(180) NOT NULL,
          `apply_time` int DEFAULT NULL,
          PRIMARY KEY (`version`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // role
        $this->execute("CREATE TABLE IF NOT EXISTS `role` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // visibility
        $this->execute("CREATE TABLE IF NOT EXISTS `visibility` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // posttype
        $this->execute("CREATE TABLE IF NOT EXISTS `posttype` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // category
        $this->execute("CREATE TABLE IF NOT EXISTS `category` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `parentId` int UNSIGNED NOT NULL,
          `title` varchar(255) NOT NULL,
          KEY `parentid` (`parentId`),
          CONSTRAINT `categoryibfk1` FOREIGN KEY (`parentId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // tag
        $this->execute("CREATE TABLE IF NOT EXISTS `tag` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // user
        $this->execute("CREATE TABLE IF NOT EXISTS `user` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `username` varchar(255) NOT NULL,
          `login` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `phone` varchar(255) DEFAULT NULL,
          `avatarPath` varchar(255) DEFAULT NULL,
          `backgroundPath` varchar(255) DEFAULT NULL,
          `roleId` int UNSIGNED NOT NULL DEFAULT 0,
          `authKey` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `login` (`login`),
          UNIQUE KEY `email` (`email`),
          KEY `roleid` (`roleId`),
          CONSTRAINT `useribfk1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // link
        $this->execute("CREATE TABLE IF NOT EXISTS `link` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // post
        $this->execute("CREATE TABLE IF NOT EXISTS `post` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `typeId` int UNSIGNED NOT NULL,
          `userId` int UNSIGNED NOT NULL,
          `title` varchar(255) NOT NULL,
          `description` text NOT NULL,
          `visibilityId` int UNSIGNED NOT NULL,
          `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `typeid` (`typeId`),
          KEY `userid` (`userId`),
          KEY `visibilityid` (`visibilityId`),
          CONSTRAINT `postibfk1` FOREIGN KEY (`typeId`) REFERENCES `posttype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `postibfk2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `postibfk3` FOREIGN KEY (`visibilityId`) REFERENCES `visibility` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // board
        $this->execute("CREATE TABLE IF NOT EXISTS `board` (
          `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
          `userId` int UNSIGNED NOT NULL,
          `title` varchar(255) NOT NULL,
          `visibilityId` int UNSIGNED NOT NULL,
          `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // boardpost
        $this->execute("CREATE TABLE IF NOT EXISTS `boardpost` (
          `boardId` int UNSIGNED NOT NULL,
          `postId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`boardId`,`postId`),
          KEY `postid` (`postId`),
          CONSTRAINT `boardpostibfk1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `boardpostibfk2` FOREIGN KEY (`boardId`) REFERENCES `board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // favorites
        $this->execute("CREATE TABLE IF NOT EXISTS `favorites` (
          `userId` int UNSIGNED NOT NULL,
          `postId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`userId`,`postId`),
          KEY `postid` (`postId`),
          CONSTRAINT `favoritesibfk1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `favoritesibfk2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // itemlink
        $this->execute("CREATE TABLE IF NOT EXISTS `itemlink` (
          `postId` int UNSIGNED NOT NULL,
          `linkId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`postId`,`linkId`),
          KEY `linkid` (`linkId`),
          CONSTRAINT `itemlinkibfk1` FOREIGN KEY (`linkId`) REFERENCES `link` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `itemlinkibfk2` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // like
        $this->execute("CREATE TABLE IF NOT EXISTS `like` (
          `userId` int UNSIGNED NOT NULL,
          `postId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`userId`,`postId`),
          KEY `postid` (`postId`),
          CONSTRAINT `likeibfk1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `likeibfk2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // outfititem
        $this->execute("CREATE TABLE IF NOT EXISTS `outfititem` (
          `outfitId` int UNSIGNED NOT NULL,
          `itemId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`outfitId`,`itemId`),
          KEY `outfititem_ibfk_1` (`itemId`),
          CONSTRAINT `outfititemibfk1` FOREIGN KEY (`itemId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `outfititemibfk2` FOREIGN KEY (`outfitId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // postcategory
        $this->execute("CREATE TABLE IF NOT EXISTS `postcategory` (
          `itemId` int UNSIGNED NOT NULL,
          `categoryId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`itemId`),
          KEY `categoryid` (`categoryId`),
          CONSTRAINT `postcategoryibfk1` FOREIGN KEY (`itemId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `postcategoryibfk2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // posttag
        $this->execute("CREATE TABLE IF NOT EXISTS `posttag` (
          `postId` int UNSIGNED NOT NULL,
          `tagId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`postId`,`tagId`),
          KEY `posttag_ibfk_2` (`tagId`),
          CONSTRAINT `posttagibfk1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `posttagibfk2` FOREIGN KEY (`tagId`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");

        // wardrobe
        $this->execute("CREATE TABLE IF NOT EXISTS `wardrobe` (
          `userId` int UNSIGNED NOT NULL,
          `postId` int UNSIGNED NOT NULL,
          PRIMARY KEY (`userId`,`postId`),
          KEY `postid` (`postId`),
          CONSTRAINT `wardrobeibfk1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `wardrobeibfk2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");
    }

    public function safeDown()
    {
        echo "m260201_init cannot be reverted.\n";
        return false;
    }
}