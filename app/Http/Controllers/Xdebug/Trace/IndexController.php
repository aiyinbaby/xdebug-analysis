<?php
namespace App\Http\Controllers\Xdebug\Trace;

use Illuminate\Routing\Controller;
use XdebugTool\Core\TraceParser;
use XdebugTool\Core\SimJsonParser\Tree as SJPTree;
use XdebugTool\Writer\TraceWriter;
use Request;
use XdebugTool\Reader\TraceReader;
use XdebugTool\Util\File;
use XdebugTool\Core\Process\ProcessController;

class IndexController extends Controller
{
    /**
     * 生成解析结果文件
     * @throws \Exception
     */
    public function create()
    {

        ini_set('memory_limit','450M');
        set_time_limit(150);

        try{
            $pid_file = config('xdebug.trace.pid_file');
            ProcessController::logPid($pid_file);

            $traceParser = new TraceParser(config('xdebug.trace.line_parser_type'));
            $traceParser->loadFile(realpath(config('xdebug.trace.default_file')));
            $traceParser->buildTree();
        }catch (\Exception $e){
            dd($e);
        }


    }

    public function stopCreate()
    {
        $pid_file = config('xdebug.trace.pid_file');
        $pid = ProcessController::getPid($pid_file);
        ProcessController::killProcess($pid);
    }


    public function look(Request $oRequest)
    {
        $data = [];

        $info = $oRequest::all();
        $nodeId = isset($info['id']) ? $info['id'] : 0;
        $parentStack = isset($info['parentStack']) ? $info['parentStack'] : '';

        $parentStack = explode(',',$parentStack);
        $parentStack = array_filter($parentStack,function($val){
           return !empty($val) || $val === 0 || $val === '0';
        });

        $selfParentStack = $parentStack;

        //子节点的祖先栈
        $parentStack[] = $nodeId;
        $childParentStack = $parentStack;

        //父节点的祖先栈
        array_pop($parentStack);
        array_pop($parentStack);
        $parentParentStack = $parentStack;

        $traceReader = new TraceReader(config('xdebug.trace.data_path'));
        $nodeData = $traceReader->getNodeData($nodeId,$selfParentStack);

        $childData = [];
        if(isset($nodeData['cid'])){
            $childData = $traceReader->getChildData($nodeData['cid'],$childParentStack);
        }

        $parentData = [];
        if(isset($nodeData['pid'])){
            $parentData = $traceReader->getParentData($nodeData['pid'],$parentParentStack);
        }

        $data = [
            'nodeData' => $nodeData,
            'childData' => $childData,
            'parentData' => $parentData
        ];
        return view('xdebug.trace.look',$data);

    }
}