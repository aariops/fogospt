<?php

namespace App\Http\Controllers;

use App\Libs\LegacyApi;

class FireController extends Controller
{
    public $fire;

    public function get($id)
    {
        if (!$id) {
            return view('index');
        }

        $this->setFireById($id);
        $risk = LegacyApi::getRiskByFire($id);
        $status = LegacyApi::getStatusByFire($id);
        $this->fire['risk'] = $risk['data'][0]['hoje'];
        $this->fire['statusHistory'] = $status['data'];

        return view('index', array('fire' => $this->fire, 'metadata' => $this->generateMetadata()));
    }

    public function getGeneralCard($id)
    {
        $this->setFireById($id);
        $risk = LegacyApi::getRiskByFire($id);
        $this->fire['risk'] = $risk['data'][0]['hoje'];

        return view('elements.risk', array('fire' => $this->fire));
    }

    public function getStatusCard($id)
    {
        $this->setFireById($id);
        $status = LegacyApi::getStatusByFire($id);
        $this->fire['statusHistory'] = $status['data'];

        return view('elements.status', array('fire' => $this->fire));
    }

    private function setFireById($id)
    {
        $this->fire = LegacyApi::getFire($id)['data'];
    }
}
