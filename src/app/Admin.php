<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Admin"); ?>

<body>
<?= Sidebar(); ?>
<div class="container">
    <div class="section">
        <h1 class="title">Admin Actions</h1>

        <div class="grid-container grid-container-2">
            <div>
                <select class="select-lot" id="add-vehicle-lot">
                    <option selected disabled hidden>Select a Lot</option>
                </select>
                <br>
                <button class="button" onclick="addVehicle()">Add Entering Vehicle</button>
            </div>
            <div>
                <select class="select-lot" id="exit-vehicle-lot">
                    <option selected disabled hidden>Select a Lot</option>
                </select>
                <br>
                <button class="button" onclick="ExitingVehicle()">Add Exiting Vehicle</button>
            </div>
            <div>
                <button id="myBtn" class="button">Add Lot</button>
            </div>
            <div>
                <select class="select-lot" id="remove-lot">
                    <option selected disabled hidden>Select a Lot</option>
                </select>
                <br>
                <button id="myBtn" class="button" onclick="RemoveLot()">Remove Lot</button>
            </div>
        </div>
    </div>


    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Add Lot</h2>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Lot Name" id="add-lot">
                <button id="myBtn" class="button" onclick="AddLot()">Add Lot</button>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        let modal = document.getElementById('myModal');

        // Get the button that opens the modal
        let btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        let span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Get Lot names and add them to dropdown
        function lotFetch() {
            apiPost("Lots", {}, function (resp) {
                let dropdowns = document.getElementsByClassName('select-lot');
                for (let i = 0; i < dropdowns.length; i++) {
                    let node = dropdowns[i];
                    node.options.length = 1;

                    for (let lot of resp) {
                        let opt = document.createElement('option');
                        opt.value = lot.id;
                        opt.innerHTML = lot.name;
                        node.appendChild(opt);
                    }
                }
            });
        }
        lotFetch();

        // Add a Vehicle
        function addVehicle() {
            let lotId = parseInt(document.getElementById('add-vehicle-lot').value, 10);
            let body = { lotId };

            if (lotId) {
                apiPost("AddVehicle", body, function (resp) {
                    if (resp.status === SUCCESS) {
                        alert('Successfully incremented vehicle to lot');
                    }
                });
            }
        }

        function ExitingVehicle() {
            let lotId = parseInt(document.getElementById('exit-vehicle-lot').value, 10);
            let body = { lotId };

            if (lotId) {
                apiPost("ExitingVehicle", body, function (resp) {
                    if (resp.status === SUCCESS) {
                        alert('Successfully added exiting vehicle to lot');
                    }
                });
            }
        }

        function RemoveLot() {
            let lotId = parseInt(document.getElementById('remove-lot').value, 10);
            let body = { lotId };

            if (lotId) {
                apiPost("RemoveLot", body, function (resp) {
                    if (resp.status === SUCCESS) {
                        alert('Successfully removed lot');
                        lotFetch();
                    }
                });
            }
        }
        
        function AddLot() {
            let lotName = document.getElementById('add-lot').value;
            let body = { lotName };

            if (lotName) {
                apiPost("AddLot", body, function (resp) {
                    if (resp.status === SUCCESS) {
                        modal.style.display = "none";
                        lotFetch();
                        alert('Successfully added lot');
                    }
                });
            }
        }
    </script>
</div>
</body>
</html>