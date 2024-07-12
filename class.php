<div class="card rounded-0 shadow">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Class List</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-primary btn-md py-1 rounded-5" type="button" id="create_new">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="class_table" class="table table-hover table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="25%">
                    <col width="50%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Class Grade & Section</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT c.*, CONCAT(c.grade , ' - ' , c.section) as grade_section, s.name FROM `class_list` c INNER JOIN `subjects` s ON c.subject_id = s.subject_id WHERE c.delete_flag = 0 ORDER BY CONCAT(c.grade , ' - ' , c.section) ASC";
                    $qry = $conn->query($sql);
                    $i = 1;
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['grade_section'] ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-2 py-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit_data" data-id="<?php echo $row['class_id'] ?>" href="#">Edit</a></li>
                                    <li><a class="dropdown-item delete_data" data-id="<?php echo $row['class_id'] ?>" data-name="<?php echo htmlspecialchars($row['name']." ".$row['grade_section']) ?>" href="#">Delete</a></li>
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
            uni_modal('Add New Class', "manage_class.php");
        });

        $('.edit_data').click(function(){
            uni_modal('Edit Class Details', "manage_class.php?id=" + $(this).data('id'));
        });

        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).data('name')+"</b> from Class List?", 'delete_data', [$(this).data('id')]);
        });

        $('table td, table th').addClass('align-middle');

        $('#class_table').DataTable({
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ]
        });
    });

    function delete_data($id){
        $('#confirm_modal button').attr('disabled', true);
        $.ajax({
            url: './Actions.php?a=delete_class',
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
