<?php
/**
 * Created by PhpStorm.
 * User: Khang
 * Date: 10/11/2017
 * Time: 10:07 PM
 */
?>
<div class="page-header">
    <h1>Contacts</h1>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th width="15%">Name</th>
        <th width="20%">Email</th>
        <th>Content</th>
        <th width="15%">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php echo (count($contact_list) < 1)?'<tr><td style="text-align:center;" colspan="4">No data</td></tr>':''?>
    <?php foreach ($contact_list as $contact):?>
        <tr>
            <?php /*<td style="width:16px;"><?php echo  $customer->id; ?></td>*/?>
            <td><?php echo  $contact->fullname; ?></td>
            <td><?php echo  $contact->email; ?></td>
            <td><?php echo  $contact->content; ?></td>
            <td><?php echo  $contact->date; ?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

