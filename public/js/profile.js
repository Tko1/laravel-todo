var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
function loadProfile(name)
{
    $.post("/login", { _token : CSRF_TOKEN,
                       "name" : name},
           function(result){
               console.log(result);
               console.log("Login! " + name);
           }).fail(function(xhr, textStatus, errorThrown) {
               console.log(xhr);
               console.log(" | " + textStatus + " | " + errorThrown);
           });;
}
/*
TODO make addProfile() just add a profile, and not load one too, for the sake of single responsibility
*/
function addProfile() {
    let name = $('#username-input').val();
    $.post("/createProfile", { _token : CSRF_TOKEN,
                               "name" : name},
           function(result){
               console.log(result);
               console.log("create profile success! " + name);
               loadProfile(name);
           }).fail(function(xhr, textStatus, errorThrown) {
               console.log(xhr);
               console.log(" | " + textStatus + " | " + errorThrown);
           });;
    //For some reason this doesn't work without this alert, and I'm not sure why
    alert("Success! Refreshing..");
    
}

/*
async function addAndLoadProfile(name)
{
    await addProfile(name);
    loadProfile(name);
}
*/
