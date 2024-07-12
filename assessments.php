<div class="card rounded-0 shadow">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Assessment List</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-primary btn-md py-1 rounded-5" type="button" id="create_new">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="assessment_table" class="table table-hover table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Class</th>
                        <th class="text-center">Component</th>
                        <th class="text-center">Quarter</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">HPS</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT a.*, CONCAT(s.name , ' ' , c.grade , ' - ' , c.section) as class, cc.name as component FROM `assessment_list` a inner join `class_list` c on a.class_id = c.class_id inner join `subjects` s on c.subject_id = s.subject_id inner join `grading_components` cc on a.component_id = cc.component_id order by class asc, component asc, quarter asc, `name` asc, hps asc ";
                    $qry = $conn->query($sql);
                    $i = 1;
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo $row['class'] ?></td>
                        <td><?php echo $row['component'] ?></td>
                        <td>
                            <?php 
                            switch($row['quarter']){
                                case '1':
                                    echo "First";
                                    break;
                                case '2':
                                    echo "Second";
                                    break;
                                case '3':
                                    echo "Third";
                                    break;
                                case '4':
                                    echo "Fourth";
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['hps'] ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-2 py-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit_data" data-id="<?php echo $row['assessment_id'] ?>" href="#">Edit</a></li>
                                    <li><a class="dropdown-item delete_data" data-id="<?php echo $row['assessment_id'] ?>" data-name="<?php echo htmlspecialchars($row['class']." - ".$row['name']) ?>" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#create_new').click(function(){
            uni_modal('Add New Assessment In Class', "manage_assessment.php");
        });

        $('.edit_data').click(function(){
            uni_modal('Edit Assessment Details In Class', "manage_assessment.php?id=" + $(this).data('id'));
        });

        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).data('name')+"</b> from the list?", 'delete_data', [$(this).data('id')]);
        });

        $('table td, table th').addClass('align-middle');

        $('#assessment_table').DataTable({
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": 6 }
            ]
        });
    });

    function delete_data($id){
        $('#confirm_modal button').attr('disabled', true);
        $.ajax({
            url: './Actions.php?a=delete_assessment',
            method: 'POST',
            data: {id: $id},
            dataType: 'JSON',
            error: function(err){
                console.log(err);
                alert("An error occurred.");
                $('#confirm_modal button').attr('disabled', false);
            },
            success: function(resp){
                if(resp.status == 'success'){
                    location.reload();
                } else {
                    alert("An error occurred.");
                    $('#confirm_modal button').attr('disabled', false);
                }
            }
        });
    }
</script>
