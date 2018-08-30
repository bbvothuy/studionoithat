<?php
/**
 * Created by PhpStorm.
 * User: Khang
 * Date: 10/11/2017
 * Time: 10:07 PM
 */
?>
<div class="page-header">
    <h1>Suppliers</h1>
</div>
<form method="post">
    <table class="table table-striped">
        <thead>
        <tr>
            <th width="25%">Name</th>
            <th width="35%">Address</th>
            <th width="20%">Phone</th>
            <th width="20%">Email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <input type="text" name="name[0]" value="" class="form-control" placeholder="New supplier name">
            </td>
            <td>
                <input type="text" name="address[0]" value="" class="form-control" placeholder="New supplier address">
            </td>
            <td>
                <input type="text" name="phone[0]" value="" class="form-control" placeholder="New supplier phone">
            </td>
            <td>
                <input type="text" name="email[0]" value="" class="form-control" placeholder="New supplier email">
            </td>
        </tr>
        <?php foreach ($suppliers as $supplier):?>
            <tr>
                <td>
                    <input type="text" name="name[<?php echo $supplier->id; ?>]" value="<?php echo $supplier->name; ?>" class="form-control">
                </td>
                <td>
                    <input type="text" name="address[<?php echo $supplier->id; ?>]" value="<?php echo $supplier->address; ?>" class="form-control">
                </td>
                <td>
                    <input type="text" name="phone[<?php echo $supplier->id; ?>]" value="<?php echo $supplier->phone; ?>" class="form-control">
                </td>
                <td>
                    <input type="text" name="email[<?php echo $supplier->id; ?>]" value="<?php echo $supplier->email; ?>" class="form-control">
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div style="text-align: right">
        <button value="save" name="submit" type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

