console.log('here')


var levelCount=0;
var prevSelection=['null'];
var prevLevelId=null;   
var state_id=0;
var stateHasCluster=false;
var roleLevel="";


var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
	 return this.href == url;
}).parent().addClass('active');


$(document).on('change','#org_id',function(){
    console.log(this.value)
    jQuery.ajax({
        type: "GET",
        url: "/getRoles",
        data: { selectedOrg:this.value},
         success:function(result){
            
            var obj = JSON.parse(result);
           
            $('#role_id') .find('option')
            .remove()
            .end()
            $('#role_id').append('<option value=0 ></option>')
            obj.forEach(element => {
                console.log(element.name+' '+element._id)
                $('#role_id').append('<option value="'+ element._id +'">'+element.name+'</option>');
            });
         }
       
      });
  });

  $(document).on('click','#addLevel',function(){
       prevLevelId='#level'+(levelCount+1);
     // console.log(prevLevelId)
      
      //console.log(prevSelection)
        levelCount++;
        var levelId='#level'+levelCount.toString();
        $(levelId) .find('option')
        .remove()
        .end();
     
      $('#levels').append('<div class="row form-group" ><p class="col-md-2">  Level '+ levelCount+'</p>'+
      '<select id="level' +levelCount +'" name="levels[]" class="form-control col-md-4" > <option value="null"></option> </select>' +
      '</div>')

        console.log(prevSelection)
      jQuery.ajax({
         
        type: "GET",
        url: "/getJurisdiction",
        data: { list: prevSelection },
         success:function(result){
             console.log(result)
            var obj = JSON.parse(result);
          
            var levelId='#level'+levelCount.toString();
          //  console.log(levelId)
           
            obj.forEach(element => {
                $(levelId).append('<option value="'+ element._id +'">'+element.levelName+'</option>')
                
            });
            //console.log($(levelId))
           
            console.log(prevSelection)
         }
       
      });
     
     

  })

  $(document).on('change','select',function(){
     
    prevSelection.push($(prevLevelId).find(":selected").text());
    console.log(prevSelection)
  })

  
$(document).on('change','#role_id',function(){
   
   jQuery.ajax({
    type: "GET",
    url: "/getLevel",
    data: { role_id:this.value},
     success:function(result){
      
      $('#state_id2').find('option')
      .remove()
      .end();
      $('#jurisdiction').find('label').remove()
      $('#jurisdiction').find('select').remove()
      $('#state_id2').append('<option value=0"> </option>');
        var obj = JSON.parse(result);
        console.log(obj[0])
        roleLevel=obj[0];
        var states=obj[1];
        states.forEach((element)=>{
          $('#state_id2').append('<option value="'+element['_id']['$oid']+'">'+element.Name+'</option>');
        })
      
     }
   
  });
  
})
 
$(document).on('change','#state_id',function(){
  console.log(this.value)
  state_id=this.value;
 var levelPage=$('#levelPage').text();
  $('#levelContainer').find('div').remove().end();
 // $('#levelContainer').find('h4').remove().end();
 // $('#levelContainer').find('br').remove().end();
  jQuery.ajax({
    type: "GET",
   
    url: "/getJidandLevel",
    data: { stateId:this.value,flevel:levelPage},
     success:function(result){
         console.log(result);
        var obj = JSON.parse(result);
     
       obj.forEach((item)=>{
         if(item=='Cluster'){stateHasCluster=true; console.log('state has cluster '+stateHasCluster)}
        $('#levelContainer').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select class="form-control col-md-6" id="'+item+'" name="'+ item +'" ></select><br/><br/></div>')
        //ajax call to populate each select tag 
        var selectTagId='#'+item;
        $(selectTagId).find('option').remove().end();
        $(selectTagId).append('<option class="form-control value="0"></option>')
        jQuery.ajax({
          type: "GET",
          url: "/populateData",
          data: { item:item,state:state_id},
           success:function(result){
            var obj = JSON.parse(result);
             // console.log(obj)
             obj.forEach((item)=>{
               console.log(item['_id']['$oid'])
              $(selectTagId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
             })
           }
         
        });

       })
       
     }
   
  });

})

$(document).on('change','#District',function(){
  var district=this.value;
  console.log(district)
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:'Taluka',state:state_id, district:district},
     success:function(result){
        $('#Taluka').find('option').remove().end();
        $('#Taluka').append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        console.log(obj)
        obj.forEach((item)=>{
          $('#Taluka').append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})


$(document).on('change','#Taluka',function(){
  console.log('here')
  var taluka=this.value;
  console.log(taluka)
  var item='Village';
  //console.log('item:'+item+' stateID:'+state_id+' taluka: '+taluka  )
  if(stateHasCluster)item='Cluster'
  console.log('item:'+item+' stateID:'+state_id+' taluka: '+taluka  )
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:item,state:state_id, taluka:taluka},
     success:function(result){
        itemId='#'+item
        $(itemId).find('option').remove().end();
        $(itemId).append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        obj.forEach((item)=>{
          $(itemId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})


$(document).on('change','#Cluster',function(){
  console.log('here')
  var cluster=this.value;
  console.log(cluster)
  var item='Village';
  
  console.log('item:'+item+' stateID:'+state_id+' cluster: '+cluster  )
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:item,state:state_id, cluster:cluster},
     success:function(result){
       console.log(result)
        itemId='#'+item
        $(itemId).find('option').remove().end();
        $(itemId).append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        obj.forEach((item)=>{
          $(itemId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})




$(document).on('change','#state_id2',function(){
  console.log(this.value)
  state_id=this.value;

  $('#jurisdiction').find('div').remove().end();
 // $('#levelContainer').find('h4').remove().end();
 // $('#levelContainer').find('br').remove().end();
  jQuery.ajax({
    type: "GET",
   
    url: "/getJidandLevel",
    data: { stateId:this.value,roleLevel:roleLevel},
     success:function(result){
       
        var obj = JSON.parse(result);
     console.log(obj)
       obj.forEach((item)=>{
         if(item=='Cluster'){stateHasCluster=true; console.log('state has cluster '+stateHasCluster)}
         if(item==obj[obj.length-1]) {

              $('#jurisdiction').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select multiple size=4 class="form-control col-md-6" id="'+item+'" name="'+ item +'[]" ></select><br/><br/></div>')
          }
         else
        $('#jurisdiction').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select class="form-control col-md-6" id="'+item+'" name="'+ item +'" ></select><br/><br/></div>')
        //ajax call to populate each select tag 
        var selectTagId='#'+item;
        $(selectTagId).find('option').remove().end();
        $(selectTagId).append('<option class="form-control value="0"></option>')
        jQuery.ajax({
          type: "GET",
          url: "/populateData",
          data: { item:item,state:state_id},
           success:function(result){
            var obj = JSON.parse(result);
             // console.log(obj)
             obj.forEach((item)=>{
              $(selectTagId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
             })
           }
         
        });

       })
       
     }
   
  });

})

$(document).on('change','#orgid,#orgidedit',function() {
 
  var orgID = $(this).val();
  if(orgID) {
    $.ajax({
        url: '/getAjaxOrgId',
        type: "GET",
        data: {orgID : orgID},
        success:function(data) {
          var obj = JSON.parse(data); 
          $('select[name="project_id[]"]').empty();
          obj.forEach(element => {
            $('select[name="project_id[]').append('<option value="'+ element['_id']['$oid'] +'">'+element['name']+'</option>');
          });
        },
        error: function (data) {
          console.log('Error in ajax response:', data.responseText);
        }
    });
  } else {
      $('select[name="project_id[]"]').empty();
  }
})