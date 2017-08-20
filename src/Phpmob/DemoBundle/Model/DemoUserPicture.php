<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\DemoBundle\Model;

use Phpmob\FileBundle\Model\Image;
use Sylius\Component\User\Model\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DemoUserPicture extends Image implements DemoUserPictureInterface
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
    }
}
