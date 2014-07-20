<?php

namespace MamuzBlog\Crypt;

use Hashids\Hashids;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class HashIdAdapterFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return AdapterInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = (array) $serviceLocator->get('Config');
        $this->validate($config);

        $hashIdconfig = $config['crypt']['hashid'];
        $hashIds = new HashIds(
            $hashIdconfig['sault'],
            $hashIdconfig['minLength'],
            $hashIdconfig['chars']
        );

        return new HashIdAdapter($hashIds);
    }

    /**
     * @param array $config
     * @throws ServiceNotCreatedException
     * @return void
     */
    private function validate(array $config)
    {
        if (!isset($config['crypt']['hashid']['sault'])
            || !isset($config['crypt']['hashid']['minLength'])
            || !isset($config['crypt']['hashid']['chars'])
        ) {
            $msg = 'Cannot find crypt configuration.'
                . ' Please copy ./vendor/mamuz-blog/config/crypt.local.php.dist'
                . ' to ./config/autoload/crypt.local.php';
            throw new ServiceNotCreatedException($msg);
        }
    }
}
