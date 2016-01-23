<!DOCTYPE html>
<html >
<head>
<style type="text/css">
#thr_table
  {
  font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
  width:600;
  border-collapse:collapse;
  }

#thr_table td, #thr_table th 
  {
  
  font-size:1em;
  border:1px solid #98bf21;
  padding:3px 7px 2px 7px;
  }

#thr_table th 
  {
  font-size:1.1em;
  text-align:center;
  padding-top:5px;
  padding-bottom:4px;
  background-color:#A7C942;
  color:#ffffff;
  }

#thr_table tr.alt td 
  {
  color:#000000;
  background-color:#EAF2D3;
  }

 .button{
width: 140px;
line-height: 38px;
text-align: center;
font-weight: bold;
color: #fff;
text-shadow:1px 1px 1px #333;
border-radius: 5px;
margin:0 20px 20px 0;
position: relative;
overflow: hidden;
}
.button.green{
border:1px solid #FFFFFF;
text-decoration-color: #FFFFFF;
box-shadow: 0 1px 2px #b9ecc4 inset,0 -1px 0 #6c9f76 inset,0 -2px 3px #b9ecc4 inset;
background: -webkit-linear-gradient(top,#90dfa2,#84d494);
background: -moz-linear-gradient(top,#90dfa2,#84d494);
background: linear-gradient(top,#90dfa2,#84d494);
}

  
input[type="text"]
{
background-color:#F0FCFF;
}
input[type="submit"]
{
font-family: Trebuchet MS; 
background-color:#F0CFF5;
width:relative; height:30px; 
}  

.imgbg{
background-image: url(/images/background.jpg);
background-repeat: no-repeat;

width: 100%;
height: 40px;
}

  
 
body {font-family: Georgia;font-size: 20px;background-color:#FFFACD;}
  
div#container{width:1300px}
div#header { background-image:url(/images/background.jpg);　background-attachment:scroll;　　height:50px; text-align:center;}
div#menu {height: 500px; width:200px; float:left;}
div#content {background-color:#F0FFFF; height:500px; width:1100px; text-align:center;}
div#footer { clear:both; text-align:center;}
h1 {margin-bottom:0;}
h2 {margin-bottom:0; font-size:14px;}
ul {margin:0; float:left;}
li {list-style:none;}
</style>


<h1><center>THEATER MANAGER</center></h1>

</head>

<body>

<div id="container">
</div>






         <br> <center>*************Click for desired operation**************</center><br>
         <?php
         /*
*/
		 require"setup.php";
                 //显示操作
		 function startform()
		 {
			 print"
                             <center>
                             <input type=submit name=save value=ADD_MOVIE>
                             <input type=submit name=del value=DEL_MOVIE>
		             <input type=submit name=mod value=MOD_PRICE>
                             
			     <input type=submit name=list value=LIST_PLAY>
                             <input type=submit name=add value=ADD_PLAY>
                             </center>
                                 ";
                         
 		 }
                 
                //一个简单的触发器，添加电影，触发操作，将电影介绍intro改成 “new movies！”
		 function saveform()
		 {/* 
                    CREATE TRIGGER `addtrg` BEFORE INSERT ON `movies`
                    FOR EACH ROW 
                    BEGIN IF new.movid NOT IN ( SELECT movid FROM display ) 
                    THEN SET new.intro = 'new movie!!!'; END IF ; END
                    $tempid=$tempid+1;*/
                     //触发器在mysql数据库里面添加，这里因为sql语句的转义符问题不能被myphpadmin正确执行，不可以添加trigger。
                     
                     require 'setup.php';
                     $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("LINK FAIL sql");			 
                     $db=mysql_select_db($DB_NAME,$connect)or die("SELECTION FAIL sql");
                      print "<p id=\"thr_table\"><tr><th>***Please use \OR' before inputing ' for SQL grammer***</th></tr></p>";
			 print"
                          <center>   
                          <br><table id=\"thr_table\">
			 <tr><th>Movie name<td><input type=text name=mov_name>
			 <tr><th>Movie year<td><input type=text name=mov_year>
			 <tr><th>Direct<td><input type=text name=mov_dir>
			 <tr><th>Introduction<td><input type=text name=mov_intro>
			 <tr><td colspan=2><center><input type=submit name=dosave value=Save_Movie_Info></center>
			 </table><br>
                         
			 ";
		 }
                 //保存至数据库**************************************************************
		 function saveend($mov_name,$mov_year,$mov_dir,$mov_intro)
		 {
			 if($mov_name==""||$mov_year==""||$mov_dir=="")//||$remark=="")
			 {
				print "<p id=\"thr_table\"><tr><th>!!!...Empty is not permitted...!!!</th></tr></p>";
                                echo "<certer><br><form><input type=button class=button green value=\"Back to previous\"     onclick=\"history.back();\"></form>";
                                echo "<br></center>";				 
                                exit;
			 }
			 require"setup.php";
			 
                         $sql="select * from $MVE where $MVE.movid>=all(select movid from $MVE);";
                        
                         $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("无法连线");
			 $db=mysql_select_db($DB_NAME,$connect)or die("无法选择资料库"); 
			 $query=mysql_query($sql,$connect)or die("无法执行SQL语法");
                         $list=mysql_fetch_array($query);
                         $id= $list[movid]+1;
                        
                         $sql="insert into $MVE values('$mov_name','$id','$mov_year','$mov_dir','$mov_intro');";
			// $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("无法连线");
			// $db=mysql_select_db($DB_NAME,$connect)or die("无法选择资料库");
                         //print $sql;
			 $query=mysql_query($sql,$connect)or die("Can't save information");
                       
			 	if($query){print "<p id=\"thr_table\"><th>***SAVE MOVIE INFO OK***</th></p>";}
				else	{print "!!!save error!!!";}	 
		 }
                 
                 
                 //触发器下的添加操作
                 //添加电影放映信息，涉及到触发器，若添加的电影不在电影表中，则自动添加该电影到电影表当中
                 //若添加的放映信息当中电影院不存在电影院的表中，报错。
                 function addplay()
                 {
                     require "setup.php";
                      print"
                          <center>   
                          <br><br><table id=\"thr_table\">
			 <tr><th>Movie id<td><input type=text name=mov_id>
                         <tr><th>Movie name<td><input type=text name=mov_name>
			 <tr><th>Theater id<td><input type=text name=thr_id>
			 <tr><th>Price id<td><input type=text name=price_id>
			 <tr><th>playtime<td><input type=text name=play_time>
			 <tr><td colspan=2><center><input id=\"thr_but\" type=submit name=doadd value=Save_MoviePlay_Info></center>
			 </table><br>
                         
			 ";
                 }
                 function addplayfin($mov_id,$mov_name,$thr_id,$price_id,$play_time)
                 {
                     if(($mov_id==""&&$mov_name=="")||$thr_id==""||$price_id==""||$play_time=="")
			 {
                                print "<p id=\"thr_table\"><th><center>!!!...Empty is not permitted...!!!</center></th></p>";
                                echo "<certer><br><form>
                                    <input type=button class=button green value=\"Back to previous\"onclick=\"history.back();\"></form>";
                                echo "<br></center>";
				exit;
			 }
                      require"setup.php";
			 //添加放映信息的触发器  
                        /*  $sql="
                             CREATE TRIGGER `play_check` BEFORE INSERT ON `display`
                             FOR EACH ROW 
                             begin 
                                    if new.movid not in(select movid from movies) 
                                       then insert into movies(movid,movname) values(new.movid,new.movname);
                                    end if; 
                             end
                             ";*/
                         $sql="select * from $DPL where $DPL.playid>=all(select playid from $DPL)";
                         $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("con fail 1");
			 $db=mysql_select_db($DB_NAME,$connect)or die("sel fail 1"); 
                         //print $sql;
			 $query=mysql_query($sql,$connect)or die("sql fail???");
                         $list=mysql_fetch_array($query);
                         $id= $list[playid]+1;
                         $sqltest="select * from $THR where thrid=$thr_id";//判断电影院存在否？
                         $querytest= mysql_query($sqltest,$connect) or die("sqltest fail");
                         $listtest=  mysql_fetch_array($querytest);
                         $thridtest=$listtest[thrname];
                         $sqltest2="select * from $PRI where priceid=$price_id";//判断价格存在否？
                         $querytest2= mysql_query($sqltest2,$connect) or die("sqltest fail2");
                         $listtest2=  mysql_fetch_array($querytest2);
                         $thridtest2=$listtest2[priceid];
                         $flag=0;//判断电影的信息写得对不对,初始为不对
                         if($thridtest&&$thridtest2)
                         {   if($mov_id)//写了电影id
                             {   if($mov_name=="")//没写电影名称
                                 {   $sql="select * from $MVE where movid='$mov_id'";
                                     $query=mysql_query($sql,$connect)or die("sql fail1");
                                     $movid=  mysql_fetch_array($query);
                                     if($movid[movid])//所填电影id在movies表中，符合条件
                                     {   $flag=1;
                                         $mov_name=$movid[movname];}
                                 }
                                 else //写了电影名称
                                 {   $sql="select * from $MVE where movid=$mov_id";
                                     $query=mysql_query($sql,$connect)or die("sql fail2");
                                     $movid=  mysql_fetch_array($query);
                                     if(!$movid[id]) //电影id不在movies表中
                                     {   $sql="select * from $MVE where movname='$mov_name'";
                                         $query=mysql_query($sql,$connect)or die("sql fail3");
                                         $movname=  mysql_fetch_array($query);
                                         if(!$movname)
                                         //电影名称和电影id都不在movies表中，说明是新的电影，允许插入，会执行另一个触发器自动添加新电影
                                             {  $flag=1;}
                                         else break;//若电影名称不在，而电影id存在，说明输入有误
                                     }
                                     if($movie[movname]==$mov_name)//电影id和电影名称相符合
                                     {
                                         $flag=1;
                                     }
                                 }
                                 if($mov_id<1000||$mov_id>9999) $flag=0;//电影id不符合要求，须在1000到9999之间！
                             }
                             else//没输入电影id
                             {
                                 $sql="select * from $MVE where movname=$mov_name";
                                 $movid=  mysql_fetch_array($sql);
                                     if($movid[movid])//所填电影id在movies表中，符合条件
                                     {
                                         $flag=1;
                                         $mov_id=$movid[movid];
                                     }
                             }
                         
                      if($flag)
                      {
                          $sqlinsert="insert into $DPL values('$mov_id','$thr_id','$price_id','$play_time','$id','$mov_name');";
			  //print "$sqlinsert";
			  $query=mysql_query($sqlinsert,$connect)or die("Can't save information");
                          if($query)
                               {print "<p id=\"thr_table\"><th>***SAVE DISPLAY INFO OK***</th></p>";}
		          else	
                              {print "!!!save error!!!";}	
                      }
                      else//电影信息不符合要求，报错
                      {
                          print "<p id=\"thr_table\"><th>ERROR, check for the movie information!</th></p>";
                          echo "<br><certer>
                              <input type=button class=button green value=\"Back to previous\"     onclick=\"history.back();\">";
                          echo "</center><br>";
                      }
                    }
                    else//电影院不存在或价格不存在！！！
                         {   print "<p id=\"thr_table\"><th>ERROR, check for the theater OR price id!</th></p>";
                         
                            echo "<certer><br><form>
                                <input type=button class=button green value=\"Back to previous\"     onclick=\"history.back();\"></form>";
                            echo "<br></center>";
                         
                         }
                 }
                 
                 
                 
                 //创建视图
                 //通过选择电影名称，创建视图，筛选出电影放映信息并显示出来
		 function listform()
		 {
			 require "setup.php";
			 $sql="select* from $MVE;";
			 $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("Link fail");
			 $db=mysql_select_db($DB_NAME,$connect)or die("sel fail");
			 $query=mysql_query($sql,$connect)or die("exe fail");
			 if($query)
			 {
				 print "<br><table id=\"thr_table\"><tr>
				 Movies_Available</tr>";
                                 print "<br><br><select name=selmovie>";
				 while($list=mysql_fetch_array($query))
				 {
                                     print "<option value=$list[movid]>$list[movname]";
                                 
                                 }
                                 print "</select><input type=submit name=showmovie value=Choose_a_movie_you_want><br><br>";
                                 print "</table>";
                         }
		 }
                 function playview($selmovie)
                 {
                         require "setup.php"; 
                         //若已存在，则drop该视图
                        
                         $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("Link fail");
			 $db=mysql_select_db($DB_NAME,$connect)or die("sel fail");
                          /*$sqli="DROP VIEW IF EXISTS playinfo";$queryi=mysql_query($sqli,$connect)or die("exe fail0");
                         //建立放映信息视图
			 $sql="
                           CREATE VIEW playinfo
                             AS
                             select mov.movname,mov.movid,thrname,thrprice,pricetype,playtime,intro 
                               from movies mov,display dpl,price pri,theater thr 
                               where mov.movid=dpl.movid and thr.thrid=dpl.thrid and pri.priceid=dpl.priceid 
                                     "  ;
                         $query=mysql_query($sql,$connect)or die("exe fail");
                         */
                         //显示视图
			 $sqlv="select * from playinfo where movid=$selmovie";
                         $queryv=mysql_query($sqlv,$connect)or die("exe failv");
                         print "<br><center> ***The movie display information are listed***</center>";
                         print "<br><table  id=\"thr_table\">";
                         print "<tr class=\"alt\">
                             <th>Moviename</th><th>Theater</th><th>Price</th><th>Type</th><th>Time</th><th>Introduction</th></tr>";
                         while($list=mysql_fetch_array($queryv))
                         {     print " <tr ><td>$list[movname]</td>
                                            <td>$list[thrname]</td>
                                            <td>$list[thrprice]</td>
                                            <td>$list[pricetype]</td>
                                            <td>$list[playtime]</td>
                                            <td>$list[intro]</td></tr>  ";
                         }
                         print"</table>";
                         echo "<certer><br><form>
                             <input type=button class=button green value=\"Back to previous\"     onclick=\"history.back();\"></form>";
                         echo "<br></center>";
                         
                 }
                 
                 //存储过程的更新操作
                 //修改电影票的价格，然后存储过程将会把预定表orders中的与该电影票相关的订单的价格全部更新为新价格
		 function modform()
		 {
			 require"setup.php";
			 $sql="select* from $PRI;";//mysql_query("set names gb2312"); 
			 $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("连接失败");
			 $db=mysql_select_db($DB_NAME,$connect)or die("选择失败");
			 $query=mysql_query($sql,$connect)or die("执行失败");
			 if($query)
			 {
				 print "<br><center><select id=\"thr_but\" name=selname>";
				 while($list=mysql_fetch_array($query))
				 {
					 print "<option value=$list[priceid]>$list[pricetype]";//the selected element's value is its "id"
				 }
				 print "</select><input type=submit name=showmod value=Submit_modify>";
			 }
		 }
		 function showmod($selname)//执行修改内容
		 {       require"setup.php";
			 $sql="select* from $PRI where priceid='$selname';";//mysql_query("set names gb2312"); 
			 $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("连接失败");
			 $db=mysql_select_db($DB_NAME,$connect)or die("选择失败");
                         //print $sql;
			 $query=mysql_query($sql,$connect)or die("执行失败");
			 if($query){
			        while($list=mysql_fetch_array($query)){
					 $id=$list[priceid];
					 $price=$list[thrprice];
					 $type=$list[pricetype];}
				 print "<tr><tr><table id=\"thr_table\">
				 <br><br><tr ><center><th colspan=2>Modify the price</center></tr>
				 <tr><th >priceid
				 <td><input type=hidden name=price_id value=$id></tr>
				 <tr><th >price
				 <td><input type=text name=price_ value=$price></tr>
				 <tr><th >type
				 <td><input type=text name=price_type value=$type></tr>
				 <tr><td colspan=2><center><input type=submit name=domod value=Commit_modify></center> </table>
				 ";}
		 }
                  function domod($priceid,$price,$type)//完成修改价格和存储过程更新操作
		 {
			 require"setup.php";
                         $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("连接失败");
                         $db=mysql_select_db($DB_NAME,$connect)or die("选择失败");
                       /* $sql="DROP PROCEDURE IF EXISTS `mod_price`";
                        $query=mysql_query($sql,$connect)or die("EXE FAIL_drop_proc");
                        $sql=" 
                             CREATE PROCEDURE mod_price(IN id_in INT(11),IN pri_in FLOAT)
                             BEGIN 
                                 UPDATE orders SET totalprice=pri_in*amount
                                    WHERE playid in
                                    (
                                    SELECT playid FROM display dpl
                                        WHERE dpl.priceid=id_in
                                    );
                             END;
                             ";
			 if(mysql_query($sql)) {
                             print "<p id=\"thr_table\"><center><th>***PROCEDURE OK***</th></center></p>";
                         }
                         else {print "<br>procedure1 fail!<br>";};
                         */
                         //存储过程 
                         if($price<0||$price>200)//价格设置不合理
                         {  print "<p id=\"thr_table\"><center><th>!!!Check for your price!!!</th></center></p>";
                            echo "<certer><br><form>
                                <input type=button class=button green value=\"Back to previous\"     onclick=\"history.back();\"></form>";
                         }
                         else
                         {  $sql = "call mod_price($priceid,$price)";
                            $query=mysql_query($sql,$connect)or die("EXE FAILxxxx");
                            if(!$query){
                                   PRINT "procedure  fail！"; 
                            }
                            else print"<p id=\"thr_table\"><th>procedure calling OK!</th></p>";
                            $sql="update $PRI set thrprice='$price',pricetype='$type' where priceid='$priceid';";
                            $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("连接失败");
                            $db=mysql_select_db($DB_NAME,$connect)or die("SEL FAIL2");
                            $query=mysql_query($sql,$connect)or die("EXE FAIL2");
                            if(!$query){print"mod error";}
                            else{
                                    print "<p id=\"thr_table\"><th>***MODIFY PRICE OK!***</th></p>";
                            } 
                         }
                  }
                 
		 //含有事务应用的删除操作
                 //删除电影的信息，如果该电影有对应的订单，则将订单也删除
		 function delform()//删除信息
		 {  
                         require "setup.php";
                         $sql="select* from $MVE;";
                         $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("LINK FAIL");			 
                         $db=mysql_select_db($DB_NAME,$connect)or die("SELECTION FAIL");
			 $query=mysql_query($sql,$connect)or die("EXECUTION FAIL");
			 if($query)
			 {
				 print "<br><br><select name=selmovie>";
				 while($list=mysql_fetch_array($query))
				 {
					 print "<option value=$list[movid]>$list[movname]";
				 }
				 print "</select><input type=submit name=dodel value=Choose_a_name_you_want><br><br>";
				
			 }
		 }
                 
		 function dodel($selname)//删除电影信息
		 {      
                        //print $selname;
			 require"setup.php";//连接数据库的信息
			 $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("Connecting failed");
			 $db=mysql_select_db($DB_NAME,$connect)or die("Selecting failed");   
                         mysql_query('START TRANSACTION');
                          
                         $sql="select * from $DPL where movid='$selname'";
                         $query=mysql_query($sql,$connect)or die("Executing failed finding in display");
                         $list=mysql_fetch_array($query);
                         //PRINT "$list[playid]";
                         if($list[playid])//删除的电影存在与放映信息表display中，判断是否进行删除
                         {
                           print "<p id=\"thr_table\"><th><center>!!!!There are display informations contains this movie!!!!</center></th></p>";
                            //显示订单, 提醒用户该电影有放映信息！！
                           print "<table  id=\"thr_table\">";
                           print "<tr class=\"alt\">
                               <th>Moviename</th><th>Theater</th><th>Price</th><th>Type</th><th>Time</th><th>Introduction</th></tr>";
                           
                         $sql="select * from playinfo where movid='$selname'";
                         $query=mysql_query($sql,$connect)or die("Executing failed finding in display");
                        
                           while($listlist=mysql_fetch_array($query))
                           {
                              print " <tr ><td>$listlist[movname]</td>
                                            <td>$listlist[thrname]</td>
                                            <td>$listlist[thrprice]</td>
                                            <td>$listlist[pricetype]</td>
                                            <td>$listlist[playtime]</td>
                                            <td>$listlist[intro]</td>
                                 </tr> ";
                           }
                           print"</table>";
                           //显示出该电影，用submit的方式提交，若用户点击则跳转到casadeddel函数进行级联删除！
                           print "<br><select name=selmovie>";
			   print "<option value=$selname>$list[movname]";
			   print "</select><input type=submit name=casadedel value=Sure_Deletion><br>";
                           //撤销删除，跳转到事物回滚roll_back函数
                           print "<input type=submit name=roll_back value=Canseling_Deletion><br><br>";
                        }  
                       
                        else//放映信息里面没有要删除的电影，可以直接删除
                        {
                            $sql="delete from $MVE where  movid='$selname';";//状态符合要求，可以进行删除
                            $query1=mysql_query($sql,$connect)or die("Executing failed 2");
                            if(!$query1)
                            {  mysql_query('ROLLBACK');
                               print"deleting error-->rollback 2";                           
                            }
                            else {  mysql_query('COMMIT');
                                    PRINT "<br>Deletion Movie $selname OK!!!</br>";
                            }
                        }
                 }
                 function roll_back()
                 {
                     require 'setup.php';
                     $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("Connecting failed");
	             $db=mysql_select_db($DB_NAME,$connect)or die("Selecting failed"); 
                     mysql_query('ROLLBACK',$connect);  
                     print"<br><p id=\"thr_table\"><th>!!!!Deletion is given up!!!!</th></p>"; 
                 }
                  function casadedel($selname)
                  {//print "casadele!!!!!!!!!!! $selname !!!!!!!!!!!!!";
                         require"setup.php";//连接数据库的信息
			 $connect=mysql_connect($DB_SERVER,$DB_USER,$DB_PASS)or die("Connecting failed");
			 $db=mysql_select_db($DB_NAME,$connect)or die("Selecting failed"); 
                         //删除与该电影有关的订单消息
                          $sqld="delete from $ORD where playid=
                                            (select playid from $DPL where movid='$selname' )";
                          //print $sql;删除与该电影有关的放映消息
                          $queryd=mysql_query($sqld,$connect)or die("Executing failed 3");   
                          $sqld2="delete from $DPL where movid='$selname'"; 
                          //删除电影信息
                          $queryd=mysql_query($sqld2,$connect)or die("Executing failed 4");   
                          $sql="delete from $MVE where  movid='$selname'";//状态符合要求，可以进行删除
                          $query1=mysql_query($sql,$connect)or die("Executing failed 2");
                          if(!$query1||!$queryd){ 
                              mysql_query('ROLLBACK');
                              print"deleting error-->rollback 2";                           
                                }
                         else {     mysql_query('COMMIT');
                                    print "<br><p id=\"thr_table\"><th>Deletion $selname OK!</th></p><br>";
                              } 
                  }
		 
                  print"<form method=post action=manager.php> <center>";
                 //(int)$tempid='11100';
                 
		 startform();
                 
                 $proc=$_POST["procecure"];
                 $add=$_POST["add"];
                 $doadd=$_POST["doadd"];
		 $save=$_POST["save"];
		 $dosave=$_POST["dosave"];
		 $del=$_POST["del"];
		 $dodel=$_POST["dodel"];
		 $casadedel=$_POST["casadedel"];
                 $roll_back=$_POST["roll_back"];
		 //$del_specified=$_POST["del_specified"];
		 $mod=$_POST["mod"];
		 $showmod=$_POST["showmod"];
		 $domod=$_POST["domod"];
                 
                
		 //$srch=$_POST["srch"];
		 //$dosrch=$_POST["dosrch"];
		 $list=$_POST["list"];
                 $showmovie=$_POST["showmovie"];
		 if($save) {saveform();}
		 else if($dosave)
			 {
				 $mov_name=$_POST["mov_name"];
				 $mov_year=$_POST["mov_year"];
				 $mov_dir=$_POST["mov_dir"];
				 $mov_intro=$_POST["mov_intro"];
				 
                                 saveend($mov_name,$mov_year,$mov_dir,$mov_intro);
				 //saveend($cus_name,$room_type,$room_cnt,$room_price,$room_date,$remark);
			 }
                         else if ($add) {   addplay(); }
                         else if ($doadd) 
                             { 
                                 $mov_id=$_POST["mov_id"];
                                 $mov_name=$_POST["mov_name"];
				 $thr_id=$_POST["thr_id"];
				 $price_id=$_POST["price_id"];
				 $play_time=$_POST["play_time"];
				 
                                 addplayfin($mov_id,$mov_name,$thr_id,$price_id,$play_time);
                             }
		 	 else if($del){delform();}
                         else if($dodel||$casadedel) 
                             { 
                                $selname=$_POST["selmovie"];
                                if($dodel){//print "$selname";
                                    dodel($selname);
                                    } 
                                else{//print "$selname";
                                    casadedel ($selname);
                                    }
                             }
                         else if($roll_back){ roll_back();}
			 //else if(){casadedel($selname);}
			 //else if($del_specified) {$cus_name=$_POST["cus_name"]; $room_date=$_POST["room_date"];del_specified($cus_name,$room_date);}
			 else if($mod) {modform();}
			 else if($showmod) {$selname=$_POST["selname"]; showmod($selname);}	
			 else if($domod) 
                         {//$id=$_POST["id"];
			 $price=$_POST["price_"];
			 $priceid=$_POST["price_id"];
			 $type=$_POST["price_type"];
			 domod($priceid,$price,$type);
			 }
			 else if($list){listform();}
                         else if($showmovie){$selmovie=$_POST["selmovie"];playview($selmovie);}
		 print "</center>
		 </form>";
		 //<div id="footer">Finished date:</div>
         ?>
</body>
</html>