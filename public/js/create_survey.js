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
  var projectId = $('#pid').attr('value');
  var categoryId = $('#cat_id').attr('value');

  //Setting this callback will make visible the "Save" button
  editor.saveSurveyFunc = function () {
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
				project_id:projectId
				},
        success:function(res){
            console.log(res)
            window.location.href = "http://127.0.0.1:8000/"+orgId+"/forms";
        }
      });
    

    }
// editor.isAutoSave = true;
// editor.showState = true;