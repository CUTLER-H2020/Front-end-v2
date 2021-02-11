<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafkaKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PythonController extends Controller
{
    public function index()
    {
        $allLines = '<ul>';
        $out = array();
        $logPath = '> ' . base_path('python/logs/test.txt') . ' 2>&1';
        $command = "python3 " . base_path('/python/test.py '.$logPath);

        $allLines .= '<li>' . date("Y-m-d H:i:s") . '</li>';

        exec($command, $out);
        foreach ($out as $line) {
            $allLines .= '<li>' . $line . '</li>';
        }

        $rnd = rand(0, 100);
        if ($rnd <= 50) {
            $allLines .= '<li>Result: <span class="label label-success">True</span></li>';
        } else {
            $allLines .= '<li>Result: <span class="label label-danger">False</span></li>';
        }

        $allLines .= '</ul>';

        return $allLines;
    }

    public function kafka(Request $request)
    {
        $allLines = '';
        $out = array();
        $pythonv = $request->python;
        $file = $request->file;

        if($pythonv==''){
            $pythonv = 'python3';
        }

        if($file==''){
            $file = base_path('python/news_crawler_kafka_interface_test.py') . " p4 Corona 2020-07-01 2020-07-01";
        } else {
            $file = base_path('python/'.$file);
        }

        @unlink(base_path('python/logs/r-m.txt'));
        $logPath = '> ' . base_path('python/logs/r-m.txt') . ' 2>&1';
        //$command = "python3 " . base_path('python/test.py') . " p4 " . $request->keyword . " " . $request->start_date . " " . $request->end_date . ' ' . $logPath;
        $command = $pythonv." " .$file.  " " . $logPath;

        exec($command);
        foreach ($out as $line) {
            $allLines .= $line . '<br />';
        }

        echo "Process Started: " . $command;

        return $allLines;
    }

    public function kafkaPost(Request $request)
    {
        $keyword = new KafkaKeyword();
        $keyword->xml_task_id = $request->xml_task_id;
        $keyword->keyword = $request->keyword;
        $keyword->start_date = $request->start_date;
        $keyword->end_date = $request->end_date;
        $keyword->started_by = Auth::user()->id;
        $keyword->save();

        $allLines = '';
        $out = array();
        $logPath = '> ' . base_path('python/logs/r-' . $keyword->id . '.txt') . ' 2>&1';
        //$command = "python3 " . base_path('python/test.py') . " p4 " . $request->keyword . " " . $request->start_date . " " . $request->end_date . ' ' . $logPath;
        $command = "python3 " . base_path('python/news_crawler_kafka_interface_test.py') . " p4 " . $request->keyword . " " . $request->start_date . " " . $request->end_date . ' ' . $logPath;

        echo $command;

        exec($command, $out);
        foreach ($out as $line) {
            $allLines .= $line . '<br />';
        }

        echo "Process Started: " . $command;

        return $allLines;
    }

    public function kafkaKeywords(Request $request)
    {
        $xml_task_id = $request->xml_task_id;
        $keywords = KafkaKeyword::where('xml_task_id', $xml_task_id)->get();
        if ($keywords->count() > 0) {
            foreach ($keywords as $keyword) {
                if ($keyword->status == 0) {
                    $filePath = base_path('python/logs/r-' . $keyword->id . '.txt');
                    if (file_exists($filePath)) {
                        $logFile = fopen($filePath, "r");
                        $logResults = '';
                        while (!feof($logFile)) {
                            $logResults .= fgets($logFile);
                        }

                        if (strpos($logResults, "'success': 'true'")) {
                            $keyword->status = 1;
                            $keyword->save();

                            @unlink($filePath);
                        } else if (strpos($logResults, "'success': 'false'")) {
                            $keyword->status = 2;
                            $keyword->save();

                            @unlink($filePath);
                        }

                        fclose($logFile);
                    }
                }
            }
        }

        return view('admin.task.kafka-keywords', compact('keywords'));
    }
}
