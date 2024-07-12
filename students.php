
<div class="card rounded-0 shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">Student List</h3>
        <div class="card-tools">
            <button class="btn btn-primary btn-sm py-2 rounded-5" type="button" id="create_new">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="30%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Class</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT ss.*, CONCAT(c.grade , ' - ' , c.section) as grade_section,s.name as sname FROM `student_list` ss inner join `class_list` c on ss.class_id = c.class_id inner join `subjects` s on c.subject_id = s.subject_id order by `name` asc,`sname` asc, `grade_section` asc ";
                    $qry = $conn->query($sql);
                    $i = 1;
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['sname'] ?></td>
                        <td><?php echo $row['grade_section'] ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-5 py-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit_data" data-id="<?php echo $row['student_id'] ?>" href="#">Edit</a></li>
                                    <li><a class="dropdown-item delete_data" data-id="<?php echo $row['student_id'] ?>" data-name="<?php echo htmlspecialchars($row['name']." [".$row['sname']." - ".$row['grade_section']."]") ?>" href="#">Delete</a></li>
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
            uni_modal('Add New Student In Class', "manage_student.php");
        });

        $('.edit_data').click(function(){
            uni_modal('Edit Student Details In Class', "manage_student.php?id=" + $(this).data('id'));
        });

        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).data('name')+"</b> from the list?", 'delete_data', [$(this).data('id')]);
        });

        $('table td, table th').addClass('align-middle');

        $('table').DataTable({
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });

    function delete_data($id){
        $('#confirm_modal button').attr('disabled', true);
        $.ajax({
            url: './Actions.php?a=delete_student',
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
