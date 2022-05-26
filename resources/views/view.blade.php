<h2 style="font-family: ''Oswald', sans-serif;', cursive;margin-left: 820px; margin-top: 20px;">To do list</h2>
<div class="card mt-2 shadow" style="width: 30rem;border-radius: 20px;" id="card">
                <div class="card-body center" style="height: fluid;" id='tobedo'>
                    <form method="POST" id="create">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control xy" id="todo" name="todo" maxlength="25" placeholder="What is to be done?" style="width: 22rem; border-radius:70px" minlength="2">
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-info" style="" id="plus" style="border-radius:100px "><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </form><br>
                   
                    <section class="sortable" >
                    @foreach($todo as $todos)
                    <div class="moved" id="{{$todos['id']}}">
                    <form class="display listc " id="{{$todos['id']}}" datapos="{{$todos['pos']}}">
                        <div class="mb-3 sortthis">
                            <div class="row">
                                <div class="col-7">
                                <div class="form-check chq">
                                <input class="form-check-input ch" <?= $todos['status'] == 1 ? 'checked' : '' ?> type="checkbox" value="" id="{{$todos['id']}}" name="added">
                                    <label class="form-check-label label nemo <?= $todos['status'] == 1 ? 'thr' : '' ?>"  for="added" id="{{$todos['value']}}" >
                                        {{$todos['value']}}
                                    </label>
                                </div>
                                </div>
                                <div class="col-2" style="margin-right:0.03px;">
                                    <button type="button" class="btn btn-light de" style="border-radius: 50px;" id="{{$todos['id']}}" ><i class="fas fa-trash"></i></button>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-light ed" style="border-radius: 50px;" id="{{$todos['value']}}"><i class="fas fa-pen"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="" style="display:none;" class="updateform listc" id="{{$todos['id']}}" datapos="{{$todos['pos']}}" >
                        <div class="mb-3 sortthis">
                                <div class="row ">
                                    <div class="col-7">
                                        <input type="text" class="form-control val" id="{{$todos['id']}}" value="{{$todos['value']}}" style="border-radius:70px" maxlength="25">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-light sv" style="border-radius: 50px;" id="{{$todos['id']}}"><i class="fas fa-save"></i></button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-light can" style="border-radius: 50px;"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                        </div>
                    </form>
</div>
                    @endforeach
                </section>                
                </div>
</div>
<script>
     $('#create').submit(function(e){
            console.log('create button clicked');
            e.preventDefault();
            let c=$('#todo').val();
            if(c.length>0){
            console.log(c);
            mydata={
                create: c
            }
            console.log(mydata);
            $.ajax({
                headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
                url:'{{ route('ajaxRequest.post') }}',
                method:"POST",
                data : JSON.stringify(mydata),
                success:function(response)
                {
                    console.log(response);
                    $('.xy').val('');
                    $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });  
                }
            });
      }});
      $('.ch').click(function(e)
      {
        console.log("Check button is clicked");
        let bx=$(this).attr('id');
        console.log(bx);
        let tb=$(this).parent().find('.nemo');
        console.log($(this).parent().find('.nemo').attr('id'));
        tb.toggleClass('thr');
        mydatax={
            dnd: bx
        }
        console.log(mydatax);
        $.ajax({
            url:'/status-update',
            method:"POST",
            data: JSON.stringify(mydatax),
            success:function(response)
            {
                console.log(response);
                $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });  
            }
        })
    });
    $('.ed').click(function(e)
    {
        $(':button').prop('disabled', true);
        $('.sv').prop('disabled', false);
        $('.can').prop('disabled', false);
        console.log('edit button clicked');
        let edv=$(this).attr('id');
        console.log(edv);
        let uplist=$(this).parent().parent();
        console.log(uplist);
        $(this).parent().parent().css('display','none');
        let upd=$(this).parent().parent().parent().parent().next();
        upd.css('display','block');
        console.log($(this).parent().parent().parent().parent().next().attr('id'));
        let upval=$(this).parent().parent().parent().parent().next().find('.val').val();
    });
        $('.sv').click(function(e)
        {
            console.log('save button clicked');
            let sv=$(this).parent().prev().children().val();
            if(sv.length>0){
            console.log(sv);
            let idli=$(this).attr('id');
            mydata={
                save:idli,
                value:sv,
            }
            let updform=$(this).parent().parent().parent().parent();
            let listdo=updform.prev().children().children();
            console.log(listdo.attr('id'));
            console.log(updform);
            console.log(mydata);
            let label =listdo.children().children().children().next();
            console.log(label.attr('class'));
            $.ajax({
                url:"/value-update",
                method: "POST",
                data: JSON.stringify(mydata),
                success:function(response)
                {
                    console.log(response);
                    console.log(label);
                    label.empty();
                    label.append(response);
                    updform.hide();
                    listdo.show();
                    $(':button').prop('disabled', false);
                    $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });  
                }

            })
         }
         else{
            $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });  
         }
        });
        $('.can').click(function()
        {
            console.log('cancel button clicked');
            let updform=$(this).parent().parent().parent().parent();
            let listdo=updform.prev().children().children();
            updform.hide();
            listdo.show();
            $(':button').prop('disabled', false);
            $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });  
        });
    $('.de').click(function(e)
    {
        console.log("Delete button clicked");
        if(confirm("Are you sure you want to delete this entry?"))
        {
            let th_btn=this;
            let did=$(this).attr('id');
            console.log(did);
            mydata={
                id: did
            }
            console.log(mydata)
            $.ajax({
                url: '/entry-delete',
                method: 'POST',
                data: JSON.stringify(mydata),
                success: function(response){
                    console.log(response);
                    $(th_btn).parent().parent().parent().parent().remove();
                    $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                });                   
                }
            });
        }
    });
    $('.label').click(function(){
        console.log('label clicked');
        $(this).prev().click();
    });
  $(document).ready(function(){
      console.log($('.moved').index())
      $('.sortable').sortable({
          stop: function(){
              let pos=$(this).sortable("toArray");
              console.log(pos)
              mydata={
                  position: pos
              }
              $.ajax({
                  url:'/prioritize',
                  method: 'POST',
                  data:JSON.stringify(mydata),
                  success: function(data){
                        console.log(data)
                        $.get('/load-page',function(data){
                        console.log(data);
                        $('.today').html(data);
                        }); 
                  }
              })
          }
      })
  })
</script>