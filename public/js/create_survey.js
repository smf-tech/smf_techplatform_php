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
        
                //Show translation tab.
                /*var editorOptions = {
                showTranslationTab: true,showJSONEditorTab: false,showTestSurveyTab: false 
                };
                var editor = new SurveyEditor.SurveyEditor("#editorElement", editorOptions);*/
        
  SurveyEditor
      .StylesManager
      .applyTheme("bootstrap");
  
  var editorOptions = {showTranslationTab: true,showJSONEditorTab: false,showTestSurveyTab: false };
  var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);
  
  var creatorId = $('#id').attr('class');
  
  var x = document.getElementsByClassName('svd_commercial_container')[0];
  x.style.display = "none";

  document.getElementsByClassName('nav-link')[1].innerText = 'Form Designer';

  var buttonElements = document.getElementsByTagName('button');
    buttonElements[3].innerHTML= '<span data-bind="text: title">Form Settings</span>';
    buttonElements[4].innerHTML= '<span data-bind="text: title">Save Form</span>';

  document.getElementById('objectSelector')[0].innerHTML = 'Form';

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
      
        // var jsonVal = jsonEl.value;
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
        success:function(res)
     {
            // alert(input.val());
            console.log(res.substr(1,res.length-2))
            window.location.href = "/"+orgId+"/setKeys/"+res.substr(1,res.length-2);
            // if(res)
            // {
            // jQuery.ajax({
            //     type: "POST",
            //     url: "/setKeys",
            //     data: { 
            //             json:jsonEl.value, 
            //             survey_id:res,                        
            //             }
            //         });
            // }
        }
      });
    }
// editor.isAutoSave = true;
// editor.showState = true;