<?php
// websocket 基础类优化
class Ws {
    const HOST = '0.0.0.0';
    const PORT = 9504;
    public $ws = null ;
    public function __construct(){
        $this->ws = new Swoole\WebSocket\Server(self::HOST,self::PORT);
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinish']);
        $this->ws->on('close',[$this,'onClose']);

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2
        ]);
        $this->ws->start();


    }

    /**
     * @notes: 监听ws连接事件
     * @param $ws
     * @param $request
     * @author: shibin <assasin0308@sina.com>
     * @datetime: 2020/10/17 10:03
     */
    public function onOpen($ws,$request){
        var_dump($request->fd);
    }

    /**
     * @notes: 监听ws事件
     * @param $ws
     * @param $frame
     * @author: shibin <assasin0308@sina.com>
     * @datetime: 2020/10/17 10:04
     */
    public function onMessage($ws,$frame){
        // 收到客户端消息
        echo "server push message is {$frame->data} ";
        // 发送给客户端
        // TODO 耗时任务 swoole-task
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
        $this->ws->task($data);
        $this->ws->push($frame->fd,"server push:".date('Y-m-d H:i:s',time()));

    }


    public function onTask($server,$task_id,$worker_id,$data){
        var_dump($data).PHP_EOL;
        sleep(10);
        return "on task finish"; // 告诉worker进程
    }

    public function onFinish($server,$task_id,$data){
        echo "task_id is :{$task_id}\n";
        echo "finish success: {$data}\n";
    }

    /**
     * @notes: 监听ws关闭事件
     * @param $ws
     * @author: shibin <assasin0308@sina.com>
     * @datetime: 2020/10/17 10:06
     */
    public function onClose($ws,$fd){
        echo "clientid:{$fd} closed";
    }

}

$ws_obj = new Ws();
