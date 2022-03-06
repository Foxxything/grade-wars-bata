<?php
  session_start(); // start session

  if ($_SESSION['AccType'] != 2 ) { // if not both account type
    header('Location: ../login.php'); // redirect to login
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Veiw</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <!-- Toggles -->
    <link rel="stylesheet" href="../css/toggles.css">
    <!-- hamper point model -->
    <link rel="stylesheet" href="../css/modal.css">
    <!-- my misc css -->
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <!-- left side of the screen -->
    <div class="container">
      <div style="margin-top: 20px;">
      <div class="row">
        <div class="col-md-9"> <!-- boddy start-->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#event" aria-selected="true">Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#manual" aria-selected="false">Manual Enter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id='approval-tab' data-toggle="tab" href="#approve" aria-selected="false">Approval</a>
            </li>
            <li class="nav-item">
              <strong>
                <a class="nav-link text-danger" data-toggle="tab" href="#danger" aria-selected="false">Danger</a>
              </strong>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent"> <!--ids need to match hrefs above-->
            <div class="tab-pane fade show active" id="event" role="tabpanel fade">
              <center><h3>Prefabs</h3><hr style="max-width: 25%;" /></center>
              
              <br>
              <center><div id="toggles">
                <label class="switch">
                  <input type="checkbox" id="hamper">
                  <span class="slider round"></span>
                </label>

                <label for='hamper' class="move">
                  <span id="hamperSpan" class="text-muted">Hamper</span>
                </label>
                <label class="switch">
                  <input type="checkbox" checked id="student">
                  <span class="slider round"></span>
                </label>

                <label for='student' class="move">
                  <span class="text-primary" id="studentSpan">Student Count</span>
                </label>
                <input type='button' id='startBtn' value='Start' class='btn btn-danger' onclick="startEvent()" />
              </div>
              <h3>Preview</h3></center><hr style="max-width: 75%;">

              <div id="StudentCountCard" style="display: inline;">
                <div class="card">
                  <div class="card-header">
                    <h4 id='header'>Your class points</h4>
                  </div>
                  <div class="card-body">
                    <div class='row'>
                      <!-- grade 9 input-->
                      <div class="col-sm-6 col-12 d-flex align-items-center"> 
                        <label for="gr9Points" class="m-0">Grade 9 points</label>
                      </div>
                      <div class="col-sm-6 col-12">
                        <input type="number" id="gr9Points" placeholder="Enter Points" class="form-control"/>
                        <div style="margin-top: 5px;"></div>
                      </div>
      
                      <!-- grade 10 input-->
                      <div class="col-sm-6 col-12 d-flex align-items-center"> 
                        <label for="gr10Points" class="m-0">Grade 10 points</label>
                      </div>
                      <div class="col-sm-6 col-12">
                        <input type="number" id="gr10Points" placeholder="Enter Points" class="form-control"/>
                        <div style="margin-top: 5px;"></div>
                      </div>
      
                      <!-- grade 11 input-->
                      <div class="col-sm-6 col-12 d-flex align-items-center"> 
                        <label for="gr11Points" class="m-0">Grade 11 points</label>
                      </div>
                      <div class="col-sm-6 col-12">
                        <input type="number" id="gr11Points" placeholder="Enter Points" class="form-control"/>
                        <div style="margin-top: 5px;"></div>
                      </div>
      
                      <!-- grade 12 input-->
                      <div class="col-sm-6 col-12 d-flex align-items-center"> 
                        <label for="gr12Points" class="m-0">Grade 12 points</label>
                      </div>
                      <div class="col-sm-6 col-12">
                        <input type="number" id="gr12Points" placeholder="Enter Points" class="form-control"/>
                        <div style="margin-top: 5px;"></div>
                      </div>
                    </div>
                    
                    <div id='buttons' class='d-flex align-items-center'>
                      <button class="btn btn-primary" id="submit">Submit</button>
                      <div style="margin-left: 5px;"></div>
                      <button class="btn btn-danger" id="reset">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="HamperCard" style="display: none;">
                <div class='card'>
                  <div class='card-header'>
                    <h4 class="text-center">Items</h4>
                  </div>
                  <div class='card-body'>
                    <form>
                      <div class="row">
                        <div class="col-md-6 col-12 d-flex align-items-center">
                          <label for="hamper-grade">Grade</label>
                        </div>
                        <div class='col-sm-6 col-12'>
                          <select class="form-control" id="hamper-grade">
                            <option>Select Grade</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                          </select>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Non-Perishable Food Items</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Peanut Butter</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Toilet Paper/Paper Towel</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Toothbrush/Toothpaste/Floss</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Box Or Bag of Feminine Products</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">New Socks/New Underwear</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Laudry Soap/Fabric Softner</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Dish Soap/Cleaning</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>

                        <div class="col-sm-6 col-12 d-flex align-items-center">
                          <label for="number" class="m-0">Childrens Book</label>
                        </div>
                        <div class="col-sm-6 col-12">
                          <input id="number" placeholder="Enter Number" class="form-control"/>
                          <div style="margin-top: 5px;"></div>
                        </div>
                      </div>

                      <div id='hamper-buttons' class="text-center">
                        <div style="margin-top: 10px;"></div>
                        <input style='width: 10%;' type='submit' id='submitBtn' value='Submit' class='btn btn-primary'/>
                        <input style='width: 10%;' type='reset' id='resetBtn' value='Reset' class='btn btn-danger'/>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="EmptyCard" style="display: none;">
                <div class='card'>
                  <div class='card-header'>
                    <h4>No Event Active</h4>
                  </div>
                  <div class='card-body'>
                    <p>No event is currently active. Please check back later.</p>
                  </div> 
                </div>
              </div>
              <div style="margin-top: 30px;"></div>
              
            </div>
            <div class="tab-pane fade" id="manual" role="tabpanel fade">
              <div style="margin: 10px;"></div>
              <div class="card">
                <div class="card-header">
                  <h4>Manual Point Change</h4>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="maualPointGrade">Grade</label>
                    <select class="form-control" id="maualPointGrade">
                      <option>Select Grade</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                    </select>
                    <div style="margin-top: 5px;"></div>
                    <label for="maualPointnumber">Number</label>
                    <input id="maualPointnumber" placeholder="Enter Number" class="form-control" readonly/>
                    <div style="margin-top: 5px;"></div>
                    <button id="maualPointSubmit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="approve" role="tabpanel fade">
              <div style="margin-top: 5px;"></div>
              <h3 class="text-center">Approval</h3><hr style="max-width: 75%;">
              <div class="card" style="background-color: transparent; border: transparent;">
                <div class='card-body' style="background-color: transparent;">
                  <div id='studentCountTable'>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Teacher</th>
                          <th scope="col">9's</th>
                          <th scope="col">10's</th>
                          <th scope="col">11's</th>
                          <th scope="col">12's</th>
                          <th scope="col">Actions</th>
                        </tr>
                        <tr id='table1'>
                          <td>Mr.Spenser</td>
                          <td>5</td>
                          <td>30</td>
                          <td>21</td>
                          <td>0</td>
                          <td>
                            <button type="button" class="btn btn-primary" onclick="aprovePoints('table1')">Approve</button>
                            <button type="button" class="btn btn-danger" onclick="denyPoints('table1')">Deny</button>
                          </td>
                        </tr>
                        <tr id='table2'>
                          <td>Ms.Place</td>
                          <td>7</td>
                          <td>21</td>
                          <td>11</td>
                          <td>5</td>
                          <td>
                            <button type="button" class="btn btn-primary" onclick="aprovePoints('table2')">Approve</button>
                            <button type="button" class="btn btn-danger" onclick="denyPoints('table2')">Deny</button>
                          </td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div id='hamperTable' style="display: none;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Teacher</th>
                          <th scope="col">Grade</th>
                          <th scope="col">Non-Perishabls</th>
                          <th scope="col">Peanut Butter</th>
                          <th scope="col">Toilet Paper/Paper Towel</th>
                          <th scope="col">Toothbrush/Toothpaste/Floss</th>
                          <th scope="col">Feminine Products</th>
                          <th scope="col">Socks/Underwear</th>
                          <th scope="col">Laudry Soap/Fabric Softner</th>
                          <th scope="col">Dish Soap/Cleaning</th>
                          <th scope="col">Childrens Book</th>
                        </tr>
                        <tr id='table1'>
                          <td>Mr.Spenser</td>
                          <td>9</td>
                          <td>5</td>
                          <td>30</td>
                          <td>21</td>
                          <td>0</td>
                          <td>7</td>
                          <td>21</td>
                          <td>11</td>
                          <td>5</td>
                          <td>
                            <button type="button" class="btn btn-primary" onclick="aprovePoints('table1')">Approve</button>
                            <button type="button" class="btn btn-danger" onclick="denyPoints('table1')">Deny</button>
                          </td>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="danger" role="tabpanel fade">
              <div style="margin-top: 5px;"></div>
              <h3 style="font-weight: 700;" class="text-center text-danger">Danger</h3><hr style="max-width: 75%;">
              <div class='card'>
                <div class='card-body'>
                  <div id='resetBtn'>
                    <button type="button" id='resetTotelPoints' class="btn btn-danger">Reset Points</button>
                    <label for='resetTotelPoints' class="move">
                      <span style="font-weight: 600; ">Will set all counted points to 0 for all grades</span>
                    </label>
                  </div>
                </div>
              </div>
              <div style="margin-top: 5px;"></div>
              <div class='card'>
                <div class='card-body'>
                  <div id='joinBtn'>
                    <input type="submit" class="btn btn-danger" onclick="fetchInfo()">Make Join Code</input>
                    <label for='resetBtn' class="move">
                      <span style="font-weight: 600; "> Will create a join code for a new user to join the system</span>
                    </label>
                    <div style="margin-top: 3px;"></div>
                    <select style="width: max-content;" class="form-control" id="accountType" required>
                      <option value="">Select Account Type</option>
                      <option>Teacher</option>
                      <option>Admin</option>
                    </select>
                    <div style="margin-top: 3px;"></div>
                    <input style="width: max-content;" type='email' class="form-control" id='email' placeholder='Email' required>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div> <!-- boddy end-->
        
        <!-- right side of the screen -->
        <div class="col-md-3">
          <div class="list-group">
            <div class="card">
              <div class="card-header">
                <h4>Total Counted Points</h4>
              </div>
              <div class="card-body">
                <form>
                  <div class="form-group">
                    <center><label style="font-size: 20px;" for="activeEvent">Active Event</label></center>
                    <input type="text" class="form-control" id="activeEvent" value="Student Count" disabled>
                  </div>
                  <hr>
                  <div class="form-group">
                    <label for="grade_9">Grade 9</label>
                    <input type="text" class="form-control" id="grade_9" name="grade_9" value="267" readonly>
                  </div>
                  <div class="form-group">
                    <label for="grade_10">Grade 10</label>
                    <input type="text" class="form-control" id="grade_10" name="grade_10" value="305" readonly>
                  </div>
                  <div class="form-group">
                    <label for="grade_11">Grade 11</label>
                    <input type="text" class="form-control" id="grade_11" name="grade_11" value="591" readonly>
                  </div>
                  <div class="form-group">
                    <label for="grade_12">Grade 12</label>
                    <input type="text" class="form-control" id="grade_12" name="grade_12" value="189" readonly>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src='../js/codeGen.js'></script>
  <script>
    // reset points
    var resetBtn = document.getElementById('resetTotelPoints');

    resetBtn.addEventListener('click', function() {
      var reset = confirm('Are you sure you want to reset all counted points?');
      if (reset) {
        var grade_9 = document.getElementById('grade_9');
        var grade_10 = document.getElementById('grade_10');
        var grade_11 = document.getElementById('grade_11');
        var grade_12 = document.getElementById('grade_12');

        grade_9.value = 0;
        grade_10.value = 0;
        grade_11.value = 0;
        grade_12.value = 0;

      }
    });

    function fetchInfo(){
      // fetch info on account type and email
      var accountType = document.getElementById('accountType').value;
      var email = document.getElementById('email').value;
      
      sendCodes(accountType, email);
    }

    // maual points edit
    var manualPointGrade = document.getElementById('maualPointGrade');
    var manualPointNumber = document.getElementById('maualPointnumber');

    // button
    var maualPointSubmit = document.getElementById('maualPointSubmit');

    manualPointGrade.addEventListener('change', function(){
      var grade = manualPointGrade;
      var Points = manualPointNumber;
      var grade_9 = document.getElementById('grade_9');
      var grade_10 = document.getElementById('grade_10');
      var grade_11 = document.getElementById('grade_11');
      var grade_12 = document.getElementById('grade_12');

      if (grade.value == 9) {
        Points.value = grade_9.value;
        Points.readOnly = false;
      } else if (grade.value == 10) {
        Points.value = grade_10.value;
        Points.readOnly = false;
      } else if (grade.value == 11) {
        Points.value = grade_11.value;
        Points.readOnly = false;
      } else if (grade.value == 12) {
        Points.value = grade_12.value;
        Points.readOnly = false;
      } else {
        Points.value = 0;
        Points.readOnly = true;
      }
    });

    maualPointSubmit.addEventListener('click', function(){
      var grade = manualPointGrade;
      var Points = manualPointNumber;
      var grade_9 = document.getElementById('grade_9');
      var grade_10 = document.getElementById('grade_10');
      var grade_11 = document.getElementById('grade_11');
      var grade_12 = document.getElementById('grade_12');

      if (grade.value == 9) {
        grade_9.value = Points.value;
      } else if (grade.value == 10) {
        grade_10.value = Points.value;
      } else if (grade.value == 11) {
        grade_11.value = Points.value;
      } else if (grade.value == 12) {
        grade_12.value = Points.value;
      }
    });

    //make md5 function
    function md5(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < charactersLength; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    }

   

    function aprovePoints(id){
      var table = document.getElementById(id);
      var grade_9 = table.getElementsByTagName("td")[1].innerHTML;
      var grade_10 = table.getElementsByTagName("td")[2].innerHTML;
      var grade_11 = table.getElementsByTagName("td")[3].innerHTML;
      var grade_12 = table.getElementsByTagName("td")[4].innerHTML;
      var grade_9_input = document.getElementById("grade_9");
      var grade_10_input = document.getElementById("grade_10");
      var grade_11_input = document.getElementById("grade_11");
      var grade_12_input = document.getElementById("grade_12");
      grade_9_input.value = parseInt(grade_9_input.value) + parseInt(grade_9);
      grade_10_input.value = parseInt(grade_10_input.value) + parseInt(grade_10);
      grade_11_input.value = parseInt(grade_11_input.value) + parseInt(grade_11);
      grade_12_input.value = parseInt(grade_12_input.value) + parseInt(grade_12);

      const removeTable = () => {
        const newOpacity = table.style.opacity ? table.style.opacity - 0.1 : 0.9;
        table.style.opacity = newOpacity;
        if (table.style.opacity <= 0.1) {
          table.style.display = "none";
          return;
        }
        setTimeout(removeTable, 50);
      };
      removeTable();
    }

    function denyPoints(id){
      var table = document.getElementById(id);
      const removeTable = () => {
        const newOpacity = table.style.opacity ? table.style.opacity - 0.1 : 0.9;
        table.style.opacity = newOpacity;
        if (table.style.opacity <= 0.1) {
          table.style.display = "none";
          return;
        }
        setTimeout(removeTable, 50);
      };
      removeTable();
    }

    // var for toggles and spans
    var hamper = document.getElementById('hamper');
    var hamperSpan = document.getElementById('hamperSpan');
    var student = document.getElementById('student');
    var studentSpan = document.getElementById('studentSpan');
    var toggles = document.getElementById('toggles');
    var studentCountCard = document.getElementById('StudentCountCard');
    var hamperCard = document.getElementById('HamperCard');
    var emptyCard = document.getElementById('EmptyCard');

    // active event text
    var event = document.getElementById("activeEvent");

    // table select for approvel table
    var approvalTab = document.getElementById('approval-tab');
    var studentCountTable = document.getElementById('studentCountTable');
    var foodHamperTable = document.getElementById('hamperTable');

    

    hamper.addEventListener('change', function() {
      if (hamper.checked) {
        hamperSpan.classList.remove('text-muted');
        hamperSpan.classList.add('text-primary');
        hamperCard.style.display = 'inline';

        studentSpan.classList.remove('text-primary');
        studentSpan.classList.add('text-muted');
        student.checked = false;
        studentCountCard.style.display = 'none';

        emptyCard.style.display = 'none';

        //event.value = "Food Hamper's";
      }
    });

    student.addEventListener('change', function() {
      if (student.checked) {
        studentSpan.classList.remove('text-muted');
        studentSpan.classList.add('text-primary');
        studentCountCard.style.display = 'inline';

        hamperSpan.classList.remove('text-primary');
        hamperSpan.classList.add('text-muted');
        hamper.checked = false;
        hamperCard.style.display = 'none';

        emptyCard.style.display = 'none';

        //event.value = "Student Counted";
      }
    });

    toggles.addEventListener('click', function() {
      if (!hamper.checked && !student.checked) {
        hamperSpan.classList.remove('text-primary');
        hamperSpan.classList.add('text-muted');
        hamperCard.style.display = 'none';

        studentSpan.classList.remove('text-primary');
        studentSpan.classList.add('text-muted');
        studentCountCard.style.display = 'none';

        //event.value = "No Event Selected";
        emptyCard.style.display = 'inline';
      }
    });

    function startEvent() {
      alert('This is where the selected event would show on teacher accounts and set as active \nNote the event text will change to reflect the selected event');

      if (hamper.checked) {
        event.value = "Food Hamper's";
      } else if (student.checked) {
        event.value = "Student Counted";
      } else {
        event.value = "No Event Selected";
      }
    }

    // approval-tab event listener
    approvalTab.addEventListener('click', function() {
      if (student.checked) {
        studentCountTable.style.display = 'inline';
        foodHamperTable.style.display = 'none';
      } else if (hamper.checked) {
        studentCountTable.style.display = 'none';
        foodHamperTable.style.display = 'inline';
      }
    });

  </script>
</html>