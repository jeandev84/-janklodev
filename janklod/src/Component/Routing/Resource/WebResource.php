<?php
namespace Jan\Component\Routing\Resource;


use Jan\Component\Routing\Resource\Support\Resource;


/**
 * class WebResource
*/
class WebResource extends Resource
{

    /**
     * Configure web items
    */
    protected function configureItems(): void
    {
        $this->add('GET', $this->path.'s', 'index')
             ->add('GET', $this->path .'/{id}', 'show', ['id' => '\d+'])
             ->add('GET|POST', $this->path, 'create')
             ->add('GET|POST', $this->path .'/{id}/edit', 'edit', ['id' => '\d+'])
             ->add('DELETE', $this->path .'/{id}/delete', 'delete', ['id' => '\d+'])
             ->add('GET', $this->path .'/{id}/restore', 'restore', ['id' => '\d+'])
        ;
    }
}