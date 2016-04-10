<?php
$dir = "../../";
$css = "main,simplebar,member,datepicker";
$js = "simplebar,datepicker,register";
$body = "member";

require_once($dir . "core/conn/config.php");
require_once($dir . "core/conn/db.php");
require_once($dir . "lib/order/get_city.php");
require_once($dir . "content/header.php");
?>  

<!--MAINCONTENT-->
<div id="maincontent">
  <div id="wrapmember">
    <div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <a href="/about-us/"><span>Home</span></a>
        <span class="sep">|</span>
        <a href="/member/register/"><span>Register</span></a>               
      </div>
      <!--END NAVPAGE-->    


      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="wrapregister">
          <h5>register</h5>                              

          <!--start personal_detail-->
          <form name="personal" method="post" action="<?php echo $dir . "mmcp/api/member_register/" ?>" class="personal">
            <div id="register">

              <h3 class="titleprofile">Personal Details</h3>                                      

              <div id="cont-firstname" class="row50">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" autocomplete="off" value=""/>
              </div>

              <div id="cont-lastname" class="row50">               
                <label class="labellastname" for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" autocomplete="off" value=""/>         
              </div>

              <div id="cont-phone" class="row">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value=""/>
              </div>              

              <div id="cont-email" class="row">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value=""/>
              </div>      

              <div id="cont-password" class="row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value=""/>
              </div>                                     

              <div id="cont-cpassword" class="row">
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" value=""/>
              </div>                                                      

              <div id="cont-dob" class="row">
                <label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="datepicker" value=""/>
              </div>                 
            </div>
            <!--end personal_detail-->    

            <!--change pass--> 
            <div id="addrdetail">
              <h3 class="titleprofile">Address Detail</h3>

              <div id="cont-streetname" class="row">
                <label for="streetname">Street Address</label>
                <input type="text" name="streetname" id="streetname" value=""/>
              </div> 

              <div id="cont-postalcode" class="row">
                <label for="postalcode">Zip / Postal Code</label>
                <input type="text" name="postalcode" id="postalcode" value=""/>
              </div>               

              <div id="cont-country" class="row">
                <label for="country">Country</label>
                <input type="text" name="country" id="country" value="Indonesia" readonly="readonly"/>
              </div>      

              <div class="row">
                <label for="city">City</label>
                <select class="select" name="city" id="city">
                  <?php
                    $data = get_city();

                    if ($data["result"]) {
                      foreach ($data["result"] as $row) {
                        $city_id = $row->city_id;
                        $city_name = $row->city_name;
                        $type = $row->type;
                        echo "
                          <option value='".$city_id."'>".$city_name." [".$type."]</option>				
                        ";
                      }
                    }
                  ?>   
                </select>
              </div>                         


              <div class="row">
                <input class="register" name="submit" type="image" src="/images/layout/member/register.png" value="register" />
              </div>                         
            </div>   
          </form>            
          <!--end change pass-->


        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  

<?php
require_once($dir . "content/footer.php");
?>