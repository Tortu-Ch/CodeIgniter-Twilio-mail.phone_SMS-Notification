
<style type="text/css">
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 2px solid black;
        padding: 2px;

    }

    table#customFields {
        color: black;
    }
                
    .add, .minus{
        border-style: ridge;
        cursor: pointer;
        border-radius: 5px;
    }

    .html, body{
        overflow:auto!important;
    }
</style>    

<script type="text/javascript">
  
    function addLine(element){
        var tr = $(element).parents("tr");		        
        var division_id = $(tr).attr("idDivision");               
		var sequence = $(document).find(".sequence_total[idDivision='"+division_id+"']").val();	
		sequence = 1 + parseInt(sequence);
		$(document).find(".sequence_total[idDivision='"+division_id+"']").val(sequence);		
        var newElement = '<tr class="estimate_divisions" idDivision="'+division_id+'" idEstimateDivision="0" sequence="'+sequence+'" >';
        newElement += '<td style="width: 50px;">';
        newElement += '<input type="hidden" name="div'+division_id+'-seq'+sequence+'[sequence]" value="'+sequence+'"/>';
        newElement += '<input type="hidden" name="div'+division_id+'-seq'+sequence+'[division_id]" value="'+division_id+'"/>';
        newElement += '<input type="hidden" name="div'+division_id+'-seq'+sequence+'[id]" value="0"/>';
        newElement += '<input type="hidden" name="div'+division_id+'-seq'+sequence+'[estimate_id]" value="<?php echo $estimate_id ?>"/>';
        newElement += '<input type="button" value="+" onclick="addLine(this)" class="add"/>';
        newElement += '<input type="button" value="-" onclick="rmLine(this)" class="minus remove"/>';
        newElement += '<td align="left" colspan="5">';
        newElement += '<input  style="width: 100%;border:none;" name="div'+division_id+'-seq'+sequence+'[project_name]" placeholder="Project name"/>';
        newElement += '</td>';
        newElement += '<td style="width:5%;">';
        newElement += '<input type="number" style="width: 100%;border:none;" name="div'+division_id+'-seq'+sequence+'[unit]" placeholder="0"/>';
        newElement += '</td>';
        newElement += '<td style="width:5%;">';
        newElement += '<input type="number" style="width: 100%;border:none;" name="div'+division_id+'-seq'+sequence+'[quantity]" placeholder="0"/>';
        newElement += '</td>';
        newElement += '<td style="width:10%;">';
        newElement += '<input type="text" style="width: 100%;border:none;" name="div'+division_id+'-seq'+sequence+'[material]" placeholder="Material"/>';
        newElement += '</td>';
        newElement += '<td style="width:5%;">';
        newElement += '<input type="number" style="width: 100%;border:none;" name="div'+division_id+'-seq'+sequence+'[labour]" placeholder="0"/>';
        newElement += '</td>';
        newElement += '<td style="width:5%;">';
        newElement += '<input type="number" class="total" name="div'+division_id+'-seq'+sequence+'[total]" onchange="sumTotalDivision(this);" style="width: 50px;border:none;" placeholder="0" value="0"/>';
        newElement += '</td>';
        newElement += '</tr>';         
        
        $(tr).after(newElement);		
    }

    function rmLine(element){
		var tr = $(element).parents("tr");		        
        var division_id = $(tr).attr("idDivision");  
        var id = $(tr).attr("idEstimateDivision");                       		
		if($(document).find(".estimate_divisions[iddivision='"+division_id+"']").length > 1){			
			sumTotalDivision(element);
            $.ajax({
                url: "<?php echo get_uri("estimates/delete_division"); ?>?id="+id,
                success: function(res){
                    $(element).parents(".estimate_divisions[iddivision='"+division_id+"']").remove();
                    alert("Eliminado");
                },
                error: function(err){
                    alert("Error");
                }             
            })
		}
    }

    function sumTotalDivision(element){
        var tr = $(element).parents("tr");
		var division_id = $(tr).attr("idDivision");                                  
        var sequence = $(tr).attr("sequence");                              
		var totalvalue = 0;
        var totals = $(document).find('.estimate_divisions[idDivision="'+division_id+'"] .total');			
		for(i = 0; i < totals.length; i++){			
			totalvalue += parseInt($(totals[i]).val());
		}				
        $(".division_total[idDivision='"+division_id+"']").find(".total_value").text(totalvalue);
        sumTotalProject();
    }

    function sumTotalProject(){
        var totalProjects = $(".total_value");
		var total = 0;
		for(i = 0; i < totalProjects.length; i++){	
			total += parseInt($(totalProjects[i]).text());
		}		
        $(".projectsub_total .sub-total").text(total);
        $(".project_total .total").text(total);
    }	
	

</script>
<div>
<?php echo form_open(get_uri("estimates/save_divisions"), array("id" => "esti-div-form", "class" => "general-form", "role" => "form")); ?>
<?php 
    $company_name = get_setting("company_name");
    $company_address = get_setting("company_address");
   
?>
<input type="hidden" name="estimate_master" value="<?php echo $estimate_id ?>" />
<button type="submit" class="btn btn-info mt0 mb0" style="margin:5px;" aria-expanded="true"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>

<table style="width:100%; margin:5px" border="0" id="customFields">
    <thead>
        <tr style="background-color: #828282;">
            <th></th>
            <th align="center" colspan="5">PROPERTY NAME/ADDRESS</th>
            <th align="center" colspan="5">PROJECT NAME</th>
        </tr>
        <tr style="background-color: #c7c7c7;">
            <th></th>
            <th align="center" colspan="5">
                <?php echo $company_name?>
            <br>
                <?php echo $company_address ?>
            </th>
            <th align="center" colspan="5">Hallway Reno</th>
        </tr>
        <tr style="background-color: #c7c7c7;">
            <td></td>
            <td align="center" colspan="5">TRADE/ITEM</td>
            <td align="center">UNIT</td>
            <td align="center">QUANTITY</td>
            <td align="center">MATERIAL</td>
            <td align="center">LABOUR</td>
            <td align="center">TOTAL</td>
        </tr>
    </thead>
    <tbody>
    <?php 
    if($division_types){ 
        $j = 0; ?>			
        <?php foreach ($division_types as $division_type) { ?>
            <tr class="division_header" style="background-color: #828282;">
                <td></td>
                <td align="left" colspan="5">
                    <label style="display: block;width: 100%;"><?php echo "Division $division_type->sequence : $division_type->name"?></label>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>               
            </tr>            
            <?php  
			$i = 1;
			if($estimates_divisions){                
                $isUptable = true;
                foreach ($estimates_divisions as $estimate_division){
                    if($estimate_division->division_id == $division_type->division_id){ ?>
                        <tr class="estimate_divisions" idDivision="<?php echo $division_type->division_id ?>" idEstimateDivision="<?php echo $estimate_division->id ?>" sequence="<?php echo $i ?>" >
                            <td style="width: 50px;">
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[sequence]" ?>" value="<?php echo $i ?>"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[division_id]" ?>" value="<?php echo $division_type->division_id ?>"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[id]" ?>" value="<?php echo  $estimate_division->id ?>"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[estimate_id]" ?>" value="<?php echo  $estimate_id ?>"/>
                                <input type="button" value="+" onclick="addLine(this)" class="add"/> 
                                <input type="button" value="-" onclick="rmLine(this)" class="minus remove"/>
                            </td>
                            <td align="left" colspan="5">
                                <input  style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[project_name]" ?>" placeholder="Project name" value="<?php echo $estimate_division->project_name ?>"/>                                
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[unit]" ?>" placeholder="0" value="<?php echo $estimate_division->unit ?>"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[quantity]" ?>" placeholder="0" value="<?php echo $estimate_division->quantity ?>"/>
                            </td>
                            <td style="width: 10%;">
                                <input type="text" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[material]" ?>" placeholder="Material" value="<?php echo $estimate_division->material ?>"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[labour]" ?>" placeholder="0" value="<?php echo $estimate_division->labour ?>"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number"  class="total" name="<?php echo "div$division_type->division_id-seq".$i."[total]" ?>" onchange="sumTotalDivision(this);" style="width: 50px;border:none;" placeholder="0" value="<?php echo $estimate_division->total ?>"/>
                            </td>
                        </tr>
                    <?php  $i++; 
                    } else if($isUptable) { 
                        $isUptable = false;
                        ?>
                        <tr class="estimate_divisions" idDivision="<?php echo $division_type->division_id ?>" idEstimateDivision="0" sequence="1" >
                            <td style="width: 50px;">						
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[sequence]" ?>" value="1"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[division_id]" ?>" value="<?php echo $division_type->division_id ?>"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[id]" ?>" value="0"/>
                                <input type="hidden" name="<?php echo "div$division_type->division_id-seq".$i."[estimate_id]" ?>" value="<?php echo  $estimate_id ?>"/>
                                <input type="button" value="+" onclick="addLine(this)" class="add"/> 
                                <input type="button" value="-" onclick="rmLine(this)" class="minus remove"/>
                            </td>
                            <td align="left" colspan="5">
                                <input  style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[project_name]" ?>" placeholder="Project name"/>                                
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[unit]" ?>" placeholder="0" value="0"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[quantity]" ?>" placeholder="0" value="0"/>
                            </td>
                            <td style="width: 10%;">
                                <input type="text" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[material]" ?>" placeholder="Material"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq".$i."[labour]" ?>" placeholder="0" value="0"/>
                            </td>
                            <td style="width:5%;">
                                <input type="number" class="total" name="<?php echo "div$division_type->division_id-seq".$i."[total]" ?>" onchange="sumTotalDivision(this);" style="width: 50px;border:none;" placeholder="0" value="0"/>
                            </td>
                        </tr>				
                    <?php }                
               } ?>               
            <?php } else { ?>
                <tr class="estimate_divisions" idDivision="<?php echo $division_type->division_id ?>" idEstimateDivision="0" sequence="1" >
                    <td style="width: 50px;">						
                        <input type="hidden" name="<?php echo "div$division_type->division_id-seq1[sequence]" ?>" value="1"/>
                        <input type="hidden" name="<?php echo "div$division_type->division_id-seq1[division_id]" ?>" value="<?php echo $division_type->division_id ?>"/>
                        <input type="hidden" name="<?php echo "div$division_type->division_id-seq1[id]" ?>" value="0"/>
                        <input type="hidden" name="<?php echo "div$division_type->division_id-seq1[estimate_id]" ?>" value="<?php echo  $estimate_id ?>"/>
                        <input type="button" value="+" onclick="addLine(this)" class="add"/> 
                        <input type="button" value="-" onclick="rmLine(this)" class="minus remove"/>
                    </td>
                    <td align="left" colspan="5">
                        <input  style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq1[project_name]" ?>" placeholder="Project name"/>                                
                    </td>
                    <td style="width:5%;">
                        <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq1[unit]" ?>" placeholder="0" value="0"/>
                    </td>
                    <td style="width:5%;">
                        <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq1[quantity]" ?>" placeholder="0" value="0"/>
                    </td>
                    <td style="width: 10%;">
                        <input type="text" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq1[material]" ?>" placeholder="Material"/>
                    </td>
                    <td style="width:5%;">
                        <input type="number" style="width: 100%;border:none;" name="<?php echo "div$division_type->division_id-seq1[labour]" ?>" placeholder="0" value="0"/>
                    </td>
                    <td style="width:5%;">
                        <input type="number" class="total" name="<?php echo "div$division_type->division_id-seq1[total]" ?>" onchange="sumTotalDivision(this);" style="width: 50px;border:none;" placeholder="0" value="0"/>
                    </td>
                </tr>				
            <?php }?>
            <tr style="background-color: #d0d046;" class="division_total" idDivision="<?php echo $division_type->division_id ?>" sequence="<?php echo $i ?>">
				<td><input type="hidden" class="sequence_total" idDivision="<?php echo $division_type->division_id ?>"  value="<?php echo $i ?>"/></td>
                <td colspan="8" align="right"> Division <?php echo $division_type->sequence ?>:</td>     
                <td> Total:</td>
                <td align="right" class="total_value"><?php echo $total_division[$j++] ?></td>
            </tr>

        <?php } 
            }else{ ?>
				<tr>
				<td colspan="12" style="text-align:center">Divisions not found</td>
				</tr>
		<?php }?>    
        </tbody>
        <tfoot>
            <tr></tr>   
            <tr></tr>               
            <tr class="projectsub_total" style="background-color: #008abe;">
                <td colspan="10" align="right" style="padding-right: 38px;">Project Sub-Total</td>
                <td align="right" class="sub-total"><?php echo $all_total ?></td>
            </tr>
            <tr></tr>
            <tr></tr>           
            <tr class="ohp_total" style="background-color: #008abe;">
                <td colspan="10" align="right" style="padding-right: 38px;">OH&P</td>
                <td align="right" class="ohp">0</td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr class="project_total" style="background-color: #008abe;">
                <td colspan="10" align="right" style="padding-right: 38px;">Project Total</td>
                <td align="right" class="total"><?php echo $all_total ?></td>
            </tr>
        </tfoot>       
    </table>    
    <?php echo form_close(); ?>
</div>