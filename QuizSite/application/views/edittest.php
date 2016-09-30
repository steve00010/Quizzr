    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#editModal">Edit Test</button>
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit test</h4>
                </div>
                <div class="modal-body" style="overflow:none">
                  <form>
                    New Name:<br>
                    <input type="text" name="newtestname" id="newtestname"  class="form-control" ><br>
                    Test Status: <br>
                    <input type="radio" name="status" id="radio_prv" value="prv"> Public<br>
                    <input type="radio" name="status" id="radio_pub" value="pub"> Private<br><br>
                    <button id="EditTestBtn" class="btn btn-info">Submit</button><br><br>

                    <button id="DeleteTestBtn" class="btn btn-danger ">Delete test</button>
                    <div id="editfeedback"></div>
            </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>