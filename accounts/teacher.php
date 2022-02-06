<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teacher Veiw</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }
    </style>
  </head>
  <body>
    <!-- left side of the screen -->
    <div class="container">
      <div style="margin-top: 20px;">
      <div class="row">
        <div class="col-md-9">
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
        <!-- right side of the screen -->
        <div class="col-md-3">
          <div class="list-group">
            <div class="card">
              <div class="card-header">
                <h4>Mx.Teacher's Requested Points</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="grade_9">Grade 9</label>
                  <input type="text" class="form-control" id="grade_9" name="grade_9" value="0" readonly>
                </div>
                <div class="form-group">
                  <label for="grade_10">Grade 10</label>
                  <input type="text" class="form-control" id="grade_10" name="grade_10" value="0" readonly>
                </div>
                <div class="form-group">
                  <label for="grade_11">Grade 11</label>
                  <input type="text" class="form-control" id="grade_11" name="grade_11" value="0" readonly>
                </div>
                <div class="form-group">
                  <label for="grade_12">Grade 12</label>
                  <input type="text" class="form-control" id="grade_12" name="grade_12" value="0" readonly>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script>
    //grade points
    var gr9Points = document.getElementById('gr9Points');
    var gr10Points = document.getElementById('gr10Points');
    var gr11Points = document.getElementById('gr11Points');
    var gr12Points = document.getElementById('gr12Points');

    //total points
    var gr9Totaled = document.getElementById('grade_9');
    var gr10Totaled = document.getElementById('grade_10');
    var gr11Totaled = document.getElementById('grade_11');
    var gr12Totaled = document.getElementById('grade_12');
    
    //buttons
    var submit = document.getElementById('submit');
    var reset = document.getElementById('reset');

    // zero out the inputs
    function zeroInputs(){
      gr9Points.value = "";
      gr10Points.value = "";
      gr11Points.value = "";
      gr12Points.value = "";
    }

    // if submit button is clicked add the points to the total and zero out the inputs
    submit.addEventListener('click', function(){
      // if the inputs are empty then replace with 0
      var gr9 = parseInt(gr9Points.value) || 0;
      var gr10 = parseInt(gr10Points.value) || 0;
      var gr11 = parseInt(gr11Points.value) || 0;
      var gr12 = parseInt(gr12Points.value) || 0;

      // add the points to the total
      gr9Totaled.value = parseInt(gr9Totaled.value) + gr9;
      gr10Totaled.value = parseInt(gr10Totaled.value) + gr10;
      gr11Totaled.value = parseInt(gr11Totaled.value) + gr11;
      gr12Totaled.value = parseInt(gr12Totaled.value) + gr12;

      // zero out the inputs
      zeroInputs();
    });

    // if reset button is clicked zero out the inputs
    reset.addEventListener('click', function(){
      zeroInputs();
    });
  </script>
</html>