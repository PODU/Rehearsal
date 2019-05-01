<?php

class MDB
{
    public function checkUserName($user){
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->teachersLogin;
        $query = array('NAME' => $user);
        $cursor = $collection->find($query);
        $count = 0;
        foreach ($cursor as $doc) {
            $count = $count + 1;
        }
        if ($count == 0) {
            return "TRUE";
        } else {
            return "FALSE";
        }
        
    }

    public function getTeacherAuth($u, $p)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->teachersLogin;
        $query = array('NAME' => $u, 'PASSWORD' => $p);
        $cursor = $collection->find($query);
        $count = 0;
        foreach ($cursor as $doc) {
            $count = $count + 1;
        }
        if ($count == 1) {
            return "TRUE";
        } else {
            return "FALSE";
        }
    }

    public function registerTeacher($name, $pass)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->teachersLogin;
        $query = array('NAME' => trim($name), 'PASSWORD' => trim($pass));
        $collection->insert($query);
        return "TRUE";
    }

    public function getActiveList()
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->activeList;
        $cursor = $collection->find();
        $res = array();
        foreach ($cursor as $doc) {
            array_push($res, array("SUBJECT" => $doc['SUBJECT'], "BY" => $doc['BY'], "ID" => $doc['_id']));
        }
        return $res;
    }

    public function getActiveSubjectList()
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->activeList;
        $cursor = $collection->find();
        $res = array();
        foreach ($cursor as $doc) {
            array_push($res, array("SUBJECT" => $doc['SUBJECT'], "BY" => $doc['BY'], "ID" => $doc['_id']));
        }
        return $res;
    }

    public function setTest($sub, $by, $time)
    {
        $res = $this->getActiveList();
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->activeList;
        foreach ($res as $r) {
            if ($sub == $r['SUBJECT'] && $by == $r['BY']) {
                return "FALSE";
            }
        }
        $query = array("SUBJECT" => trim($sub), 'BY' => trim($by), 'TIME' => trim($time));
        $collection->insert($query);
        return $query['_id'];
    }

    public function deleteStudent($id){
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->studentLogin;
        $content = array('_id' => new MongoId($id));
        $collection->remove($content,array('justOne'=>true));
        return "TRUE";
    }

    public function deleteScores($id){
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->scoreList;
        $content = array('_id' => new MongoId($id));
        $collection->remove($content,array('justOne'=>true));
        return "TRUE";
    }

    public function deleteQuestion($id){
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->questionList;
        $content = array('_id' => new MongoId($id));
        $collection->remove($content,array('justOne'=>true));
        return "TRUE";
    }

    public function addStudent($test, $name, $prn, $pass)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->studentLogin;
        $content = array('TEST' => trim($test), 'NAME' => trim($name), 'PRN' => trim($prn), 'PASSWORD' => trim($pass));
        $collection->insert($content);
        return "TRUE";
    }

    public function addQuestion($id, $question, $option1, $option2, $option3, $option4, $answer, $co, $type)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->questionList;
        $content = array('TEST' => trim($id), 'QUESTION' => trim($question), 'OPTION1' => trim($option1), 'OPTION2' => trim($option2), 'OPTION3' => trim($option3), 'OPTION4' => trim($option4), 'ANSWER' => trim($answer), 'CO' => trim($co), 'TYPE' => trim($type));
        $collection->insert($content);
        return "TRUE";
    }

    public function getName($prn, $test)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $prn = trim($prn);
        $collection = $conn->COLLEGE->studentLogin;
        $query = array('TEST' => $test);
        $c = $collection->find($query);
        foreach ($c as $a) {
            if ($a['PRN'] == $prn) {
                return $a['NAME'];
            }
        }
        return "NULL";
    }

    public function checkScore($id,$prn){
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->scoreList;
        $query = array('PRN' => $prn);
        $cursor = $collection->find($query);
        $count = 0;
        foreach ($cursor as $doc) {
            if($doc['TEST']==$id){
                $count+=1;
            }
        }
        if ($count == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addScoreArr($test, $prn, $name, $arr)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->scoreList;
        //$collection = $conn->COLLEGE->$id;
        $content = array('TEST' => $test, 'PRN' => $prn, 'NAME' => $name, 'SCORE' => $arr);
        $collection->insert($content);
    }

    public function getStudentAuth($u, $p)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->studentLogin;
        $query = array('PRN' => $u);
        $cursor = $collection->find($query);
        foreach ($cursor as $doc) {
            if ($doc['PASSWORD'] == $p) {
                return $doc['NAME'];
            }
        }
        return "FALSE";
    }

    public function getQuestionList($test)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->questionList;
        $query = array('TEST' => $test);
        $cursor = $collection->find($query);
        $res = array();
        foreach ($cursor as $doc) {
            $a = array('QUESTION' => $doc['QUESTION'], 'OPTION1' => $doc['OPTION1'], 'OPTION2' => $doc['OPTION2'], 'OPTION3' => $doc['OPTION3'], 'OPTION4' => $doc['OPTION4'], 'ANSWER' => $doc['ANSWER']);
            array_push($res, $a);
        }
        return $res;
    }

    public function checkLogin($test, $prn)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->scoreList;
        $res = $collection->find(array('TEST' => $test));
        foreach ($res as $r) {
            if ($r['prn'] == $prn) {
                return "FALSE";
            }
        }
        return "TRUE";
    }

    public function getScoreArr($id)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $id = 'score' . trim($id);
        $prn = trim($prn);
        $collection = $conn->COLLEGE->$id;
        $cur = $collection->find($query);
        $arr = array();
        $a = array();
        foreach ($cur as $doc) {

            for ($i = 0; $i <= count($doc) - 1; $i++) {
                array_push($a, $doc[$i]);
            }

            /*$line = 'array($doc[\'PRN\']';
            $a = '$doc[\'';
            for($i=1;$i<=count($doc)-1;$i++){
            $line = $line.','.$a.$i.'\']';
            }
            $line = $line.');';
            echo '<h1>'.$line.'</h1>';*/
            //$a = array($doc['0'],$doc['1'],$doc['2'],$doc['3'],$doc['4'],$doc['5']);//,$doc['6'],$doc['7'],$doc['8'],$doc['9'],$doc['10']);//,$doc['11'],$doc['12'],$doc['13'],$doc['14'],$doc['15'],$doc['16'],$doc['17'],$doc['18'],$doc['19'],$doc['20'],$doc['21'],$doc['22'],$doc['23'],$doc['24'],$doc['25'],$doc['26'],$doc['27'],$doc['28'],$doc['29'],$doc['30'],$doc['31'],$doc['32'],$doc['33'],$doc['34'],$doc['35'],$doc['36'],$doc['37'],$doc['38'],$doc['39'],$doc['40'],$doc['41'],$doc['42'],$doc['43'],$doc['44'],$doc['45'],$doc['46'],$doc['47'],$doc['48'],$doc['49'],$doc['50'],$doc['51'],$doc['52'],$doc['53'],$doc['54'],$doc['55'],$doc['56'],$doc['57'],$doc['58'],$doc['59'],$doc['60'],$doc['61'],$doc['62'],$doc['63'],$doc['64'],$doc['65'],$doc['66'],$doc['67'],$doc['68'],$doc['69'],$doc['70'],$doc['71'],$doc['72'],$doc['73'],$doc['74'],$doc['75'],$doc['76'],$doc['77'],$doc['78'],$doc['79'],$doc['80'],$doc['81'],$doc['82'],$doc['83'],$doc['84'],$doc['85'],$doc['86'],$doc['87'],$doc['88'],$doc['89'],$doc['90'],$doc['91'],$doc['92'],$doc['93'],$doc['94'],$doc['95'],$doc['96'],$doc['97'],$doc['98'],$doc['99'],$doc['100']);
            array_push($arr, $a);
        }
        return $arr;
    }

    public function getTimer($test)
    {
        $conn = new MongoClient();
        if ($conn == null) {
            die("CONNECTION ERROR");
        }
        $collection = $conn->COLLEGE->activeList;
        $query = array('_id' => new MongoId($test));
        $cursor = $collection->find($query);
        foreach ($cursor as $doc) {
            return $doc['TIME'];
        }
        return "FALSE";
    }

}

/*

function getSubjectList(){
$conn = new MongoClient();
if($conn==null){
die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->qustionList;
$c = $collection->distinct("SUBJECT");
return $c;
}

function getUnitList($sub){
$conn = new MongoClient();
if($conn==null){
die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->qustionList;
//$c = $conn->COLLEGE->command(array('distinct'=>'qustionList','key'=>'UNIT','query'=>array('SUBJECT'=>array('$eq'=>$sub))));
$query = array('SUBJECT'=>array('$eq'=>$sub));
$c = $collection->distinct("UNIT",$query);
return $c;
}

function getActiveSubjectsAndUnits(){
$conn = new MongoClient();
if($conn==null){
die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->activeList;
$cursor = $collection->find();
$res = array();
foreach($cursor as $doc){
$s = $doc['SUBJECT'];
$ut = array();
foreach($doc['UNITS'] as $u){
array_push($ut,$u);
}
array_push($res,array("SUBJECT"=>$s,"UNITS"=>$ut,"ID"=>$doc['_id']));
}
return $res;
}

function removeFromActiveList($id){
$conn = new MongoClient();
if($conn==null){
die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->activeList;
$collection->remove(array('_id' => new MongoID($id)));
echo "DONE";
}

function getStudentLogins(){
$conn = new MongoClient();
if($conn==null){
die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->studentLogin;
$cursor = $collection->find();
return $cursor;
}

 */
?>
