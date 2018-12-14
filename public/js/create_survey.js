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
  var c_id = $('#id').attr('class');

  console.log(c_id);

//   var surveyJSON ={
//       "pages": [
//        {
//         "name": "page1"
//        }
//       ]
//      };
     
  //Setting this callback will make visible the "Save" button
  editor.saveSurveyFunc = function () {
      //save the survey JSON
      var jsonEl = document.getElementById('surveyContainer');
      jsonEl.value = editor.text;
    //   surveyJSON = jsonEl.value; 
    var orgId=window.location.pathname.split('/')[1];
    console.log(orgId)
    

    jQuery.ajax({
        type: "POST",
       
        url: "/getJSON",
        data: { json:jsonEl.value, creator_id:c_id ,orgId:orgId},
        success:function(res){
            console.log(res)
            window.location.href = "http://127.0.0.1:8000/"+orgId+"/forms";
        }
      });
    

    }
// editor.isAutoSave = true;
// editor.showState = true;