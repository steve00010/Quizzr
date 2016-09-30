    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create New Test</button>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create New test</h4>
                </div>
                <div class="modal-body" style="overflow:none">
                    <div id="testform1">
                        <form class="form-horizontal">
                            <fieldset>
                            <div class="removeAtEnd">
                                <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Test name</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Test name" id="testnameinput" name="testname" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="select" class="col-lg-2 control-label">Number of questions</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" id="qNumb">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="select" class="col-lg-2 control-label">Status</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" id="oStatus">
                                            <option>Public</option>
                                            <option>Private</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <button class="btn btn-success" id="GenQuestions">Create Questions</button>
                                    </div>
                                    <div id="nameerror">
                                    <br>
                                    <br>
                                    </div>
                                </div>
                            </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12"  id="questionlist"></div>
                                        </div>
                                        <div class="row removeAtEnd">
                                            <label for="select" class="col-lg-2 control-label" id="qAnsCorrectLabel">Correct Answer</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" id="qAnsCorrect">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        <div class="col-lg-4 col-lg-push-2 ">
                                            <button class="btn btn-primary" id="nextQuest">Next Question</button>
                                            <p id="Qtooltip">Questions left blank at the end will be ignored. </p>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <button class="btn btn-info" id="GenAnswers">Create Answers</button>
                                              </div>

                                        </div>
                                    </div>

                            </fieldset>
                        </form>
                        <div class="progress progress-striped active">
                             <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>