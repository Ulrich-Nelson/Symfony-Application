<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\cacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;

//fichier pour gérer l'upload de nos fichiers
class ImageCacheSubscriber  implements EventSubscriber
{
    /**
     * cacheManager
     *
     * @var mixed
     */
    private $cacheManager;
    /**
     * uploaderHelper
     *
     * @var mixed
     */
    private $uploaderHelper;

    /**
     * __contruct
     *
     * @param  mixed $cacheManager
     * @param  mixed $uploaderHelper
     * @return void
     */
    public function __contruct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Picture) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Picture) {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}
