<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class TestServer extends AbstractAction
{
    public function getTitle()
    {
        return 'Testing';
    }

    public function getIcon()
    {
        return 'voyager-lab';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-default pull-right',
            'style' => 'border: 0px; margin-right: 5px'
        ];
    }

    public function getDefaultRoute()
    {
        return route('servers.test', ['server' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'servers';
    }
}