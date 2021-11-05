<?php
namespace Jan\Component\Routing\Resource;


use Jan\Component\Routing\Resource\Support\Resource;


/**
 * Class Api Resource
*/
class ApiResource extends Resource
{

    /**
     * Configure api resource
    */
    protected function configureItems(): void
    {
        $this->add('GET', $this->path.'s', 'list')
             ->add('GET', $this->path .'/{id}', 'show', ['id' => '\d+'])
             ->add('POST', $this->path, 'create')
             ->add('PUT', $this->path .'/{id}', 'edit', ['id' => '\d+'])
             ->add('DELETE', $this->path .'/{id}', 'delete', ['id' => '\d+']);
    }
}