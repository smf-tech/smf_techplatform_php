$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  SurveyEditor
      .StylesManager
      .applyTheme("bootstrap");
  
  var editorOptions = {};
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

    jQuery.ajax({
        type: "POST",
       
        url: "/getJSON",
        data: { json:jsonEl.value, creator_id:c_id }
      });
    }

// editor.isAutoSave = true;
// editor.showState = true;