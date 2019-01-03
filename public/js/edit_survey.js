$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  Survey.surveyLocalization.locales["mr"] = Survey.surveyLocalization.locales["en-us"];
                Survey.surveyLocalization.localeNames["mr"] = "Marathi"; 
                Survey.surveyLocalization.locales["hi"] = Survey.surveyLocalization.locales["en-us"];
                Survey.surveyLocalization.localeNames["hi"] = "Hindi";
                Survey.surveyLocalization.supportedLocales = ["en", "mr","hi"];
        
  SurveyEditor
      .StylesManager
      .applyTheme("bootstrap");
  
  var editorOptions = {showTranslationTab: true,showJSONEditorTab: false,showTestSurveyTab: false };
  var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);
  
//   var creatorId = $('#id').attr('class');
  var projectId = $('#pid').attr('value');
  var categoryId = $('#cat_id').attr('value');

  editor.text = $('#id').attr('value');
  var surveyID = $('#id').attr('surveyID');

  console.log(surveys);

  var orgId=window.location.pathname.split('/')[1];

  editor.saveSurveyFunc = function () {
     
      var jsonEl = document.getElementById('surveyContainer');
      jsonEl.value = editor.text;
      //surveyJSON = jsonEl.value; 
      var orgId=window.location.pathname.split('/')[1];
      console.log(orgId);

      active = $('#active').is(":checked");
      editable = $('#editable').is(":checked");
      multiple_entry = $('#multiple_entry').is(":checked");
      var assigned_roles = $('#assigned_roles').val();
      //console.log(assigned_roles);return;

      var projectId = $('#pid').val();
      var categoryId = $('#cat_id').val();  
      var microserviceId = $('#service_id').val();

      var entityId = $('#entity_id').val();    

    jQuery.ajax({
        type: "POST",
        url: "/saveEditedform",
        data: { json:jsonEl.value, 
                // creator_id:creatorId,
                surveyID:surveyID,
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