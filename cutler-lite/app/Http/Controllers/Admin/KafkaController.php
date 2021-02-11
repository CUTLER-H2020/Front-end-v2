<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KafkaController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Kafka';
        $this->page['sub_title'] = '';
    }

    public function messages()
    {
        $this->page['title'] = 'Messages';
        return view('admin.kafka.messages')->with('page', $this->page);
    }

    public function topics()
    {
        $this->page['title'] = 'Topics';
        return view('admin.kafka.topics')->with('page', $this->page);
    }
}
