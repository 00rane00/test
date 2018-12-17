<?php


class HomeController
{
    private $db;
    private $route,$params;
    private $body="";
    public function __construct()
    {
        $conf = require("conf.php");
        $dns = 'mysql:dbname='.$conf['db'].";host=".$conf['host'];
        $this->db = new PDO($dns, $conf['user'], $conf['pass']);

        $this->route = $_GET;
        $this->params = $_REQUEST;
        switch ($this->route['path']){
            case 'details':
                $this->GetDetails();
                break;
            case 'load':
                $this->load();
                header('Location: /');
                break;
            default:
               $this->GetList();
                break;
        }
    }
    private function load(){
        try{
            if(empty($_FILES['json']['tmp_name'])){
                return "No File";
            }
            $json = json_decode(file_get_contents($_FILES['json']['tmp_name']),true);
          $sql = "insert into datas (phone_id,country_id,lead_name) VALUES (:phone_id,:country_id,:lead_name)";
          $this->db->beginTransaction();
          $trans = $this->db->prepare($sql);
            foreach ($json as $data){
                $trans->execute($data);
            }
            $this->db->commit();

        }catch (\Exception $exception){
            return "file error";
        }
    }

    private function select($id = null)
    {
        $where = "";
        if ($id) {
            $where = " where datas.id = $id";
        }
        $ad=  $this->db->query("select * from datas left join country on datas.country_id = country.id left join phone on datas.phone_id = phone.id ".$where);
        return $ad->fetchAll();

    }
    
    protected function GetList(){
        $view = "";
        $datas = $this->select();
        foreach ($datas as $key =>$data){
            $view .=$this->generateView($data);
        }
        $this->body  = $view;
    }

    protected function GetDetails(){
        $view = "";
        $data = $this->select($this->params['id']);
        if(isset($data[0])) {
            $view = $this->generateView($data[0]);
        }else{
         $view  = "No Data";
        }
        $this->body  = $view;
    }

    private function generateView($data){
        $name = isset($data['name'])?$data['name']:null;
        $phone = isset($data['phone'])?$data['phone']:null;
        $view ="<tr ><th>".$this->filter($name)."</th><th>".$this->generateLink($phone)."</th><th><a href='/details?id=".$data[0]."'>".$data['lead_name']."</a></th></tr>";
        return $view;
    }

    protected function filter($value){
        if($value == $this->params['location']){
            return "<span style='color: burlywood;'>$value</span>";
        }else{
            return $value;
        }
    }

    protected function generateLink($value){
        if($value == $this->params['phone']){
            return "<span style='color: burlywood;'>$value</span>";
        }else{
            return $value;
        }
    }

    public function html(){
        echo "<html><head><title></title>
        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
        <!-- Optional theme -->
        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\"</head><body>
        <div class='col-md-1'>
            <form method='post' action='load' enctype='multipart/form-data' class='form'>
            <input class='form-control' type='file' name='json'>
            <input type='submit' class='btn'>
            </form>
        </div>
        <div class='col-md-6 col-md-offset-2'>
        <table class='table'>
        <thead>
        <form type='get' >
           <th><input class='form-control' type='text' name='location' placeholder='location'></th>
           <th><input class='form-control' type='text' name='phone' placeholder='phone'></th>
           <th><input class='btn' type='submit'></th>
           </form>
        </thead>
        <tbody>
        $this->body
        </tbody>
        </table></div>
        </body></html>";
    }

}