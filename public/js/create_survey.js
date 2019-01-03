$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  SurveyEditor
      .StylesManager
      .applyTheme("bootstrap");
  
  var editorOptions = {showTranslationTab: true,showJSONEditorTab: false,showTestSurveyTab: false };
  var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);
  
  var creatorId = $('#id').attr('class');
  
  
//  ko.applyBindings(vm);

  $(document).on('click','#svd-survey-settings',function(){
    console.log("hello");
    $("input").click(function(){

        // var viewModel = {
        //     title : ko.observable()
        //  };
         
        //  var vm = new AppViewModel();
        
        // console.log(viewModel.title());

        // this.filter = ko.computed({
        //     read: function() { return ""; }, // <-- not recommended, read context!
            // write: function(newValue) {
            //   // You're free to discard the newValue   <-- not recommended, read context!
            //   alert("Input has been changed.");
            // }
        //   });

        console.log("bye");
      });

  });
//   console.log("data-bind: " + $("span").data().bind);
//   console.log("value: " + $("span").val());

//   var viewModel = {
//     title: ko.observable() // Initially blank
// };
// viewModel.title = ko.pureComputed(function() {
//     return this.title();
// }, viewModel);

// console.log(viewModel.title);

//   console.log(this.title());

  //Setting this callback will make visible the "Save" button
  editor.saveSurveyFunc = function () {
    // console.log(editor.text);
    
//   console.log("data-bind: " + $("span").data().bind);
//   console.log("value: " + $("span").val());

      //save the survey JSON
      var jsonEl = document.getElementById('surveyContainer');
      jsonEl.value = editor.text;
      //surveyJSON = jsonEl.value; 
      var orgId=window.location.pathname.split('/')[1];
      //console.log(orgId);
      var active = $('#active').is(":checked");
      var editable = $('#editable').is(":checked");
      var multiple_entry = $('#multiple_entry').is(":checked");
      var assigned_roles = $('#assigned_roles').val();
      

      //console.log(assigned_roles);return;


      //   var projectId = document.getElementById("pid");
    //   var projectId = $('#pid option:selected').attr('value');
    var projectId = $('#pid').val();

    //   var categoryId = document.getElementById("cat_id");
    //   var categoryId = $('#cat_id option:selected').attr('value');
    var categoryId = $('#cat_id').val();
    //   var microserviceId = document.getElementById("service_id");
    //   var microserviceId = $('#service_id option:selected').attr('value');
    var microserviceId = $('#service_id').val();

    var entityId = $('#entity_id').val();

    jQuery.ajax({
        type: "POST",
        url: "/savebuiltform",
        data: { json:jsonEl.value, 
                creator_id:creatorId,
                orgId:orgId,
                active:active,
                editable:editable,
                multiple_entry:multiple_entry,
                assigned_roles:assigned_roles,
				category_id:categoryId,
                project_id:projectId,                
                microservice_id:microserviceId,
                entity_id:entityId
				},
        success:function(res){
            console.log(res)
            window.location.href = "http://127.0.0.1:8000/"+orgId+"/forms";
        }
      });
    }
// editor.isAutoSave = true;
// editor.showState = true;