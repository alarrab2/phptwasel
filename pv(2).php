<?php
	/*
	Telegram.me/OneProgrammer
	Telegram.me/SpyGuard
	Github.com/mehrab-wj/SimplePHPBot
	----[ Lotfan Copy Right Ro Rayat Konid <3 ]----
	############################################################################################
	# if you need Help for develop this source , You Can Send Message To Me With @SpyGuard_BOT #
	############################################################################################
	*/
	define('API_KEY','**TOKEN**');
	//----######------
	
	function makereq($method,$datas=[]){
	$url = "https://api.telegram.org/bot".API_KEY."/".$method;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
	$res = curl_exec($ch);
	if(curl_error($ch)){
	var_dump(curl_error($ch));
	}else{
	return json_decode($res);
	}
	}
	//---------
	$update = json_decode(file_get_contents('php://input'));
	var_dump($update);
	//=========
	$chat_id = $update->message->chat->id;
	$message_id = $update->message->message_id;
	$from_id = $update->message->from->id;
	$name = $update->message->from->first_name;
	$contact = $update->message->contact;
	$cnumber = $update->message->contact->phone_number;
	$cname = $update->message->contact->first_name;
	
	$photo = $update->message->photo;
	$video = $update->message->video;
	$sticker = $update->message->sticker;
	$file = $update->message->document;
	$music = $update->message->audio;
	$voice = $update->message->voice;
	$forward = $update->message->forward_from;
	
	$username = $update->message->from->username;
	$textmessage = isset($update->message->text)?$update->message->text:'';
	$reply = $update->message->reply_to_message->forward_from->id;
	$stickerid = $update->message->reply_to_message->sticker->file_id;
	//------------
	$_sticker = file_get_contents("data/setting/sticker.txt");
	$_video = file_get_contents("data/setting/video.txt");
	$_voice = file_get_contents("data/setting/voice.txt");
	$_file = file_get_contents("data/setting/file.txt");
	$_photo = file_get_contents("data/setting/photo.txt");
	$_music = file_get_contents("data/setting/music.txt");
	$_forward = file_get_contents("data/setting/forward.txt");
	$_joingp = file_get_contents("data/setting/joingp.txt");
	//------------
	$admin = **ADMIN**;
	$bottype = "**free**";
	$step = file_get_contents("data/".$from_id."/step.txt");
	$type = file_get_contents("data/".$from_id."/type.txt");
	$list = file_get_contents("data/blocklist.txt");
	//---Buttons----
	$btn1_name = file_get_contents("data/btn/btn1_name");
	$btn2_name = file_get_contents("data/btn/btn2_name");
	$btn3_name = file_get_contents("data/btn/btn3_name");
	$btn4_name = file_get_contents("data/btn/btn4_name");
	
	$btn1_post =  file_get_contents("data/btn/btn1_post");
	$btn2_post =  file_get_contents("data/btn/btn2_post");
	$btn3_post =  file_get_contents("data/btn/btn3_post");
	$btn4_post =  file_get_contents("data/btn/btn4_post");
	
	//-----------
	function SendMessage($ChatId, $TextMsg)
	{
	makereq('sendMessage',[
	'chat_id'=>$ChatId,
	'text'=>$TextMsg,
	'parse_mode'=>"MarkDown"
	]);
	}
	function SendSticker($ChatId, $sticker_ID)
	{
	makereq('sendSticker',[
	'chat_id'=>$ChatId,
	'sticker'=>$sticker_ID
	]);
	}
	function Forward($KojaShe,$AzKoja,$KodomMSG)
	{
	makereq('ForwardMessage',[
	'chat_id'=>$KojaShe,
	'from_chat_id'=>$AzKoja,
	'message_id'=>$KodomMSG
	]);
	
	}
	function save($filename,$TXTdata)
	{
	$myfile = fopen("data/".$filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
	//===========
	if (strpos($list , "$from_id") !== false  ) {
		SendMessage($chat_id,"You Are Blocked!");
	}
	elseif(isset($update->callback_query)){
    $callbackMessage = 'تم التحديث 👍🏻';
    var_dump(makereq('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    //SendMessage($chat_id,"$data");
	
    if ($data == "sticker" && $_sticker == "✅") {
      save("setting/sticker.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>"⛔️",'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "sticker" && $_sticker == "⛔️") {

	 save("setting/sticker.txt","✅");
	     var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>"✅",'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
     if ($data == "video" && $_video == "✅") {
      save("setting/video.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>"⛔️",'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
     if ($data == "video" && $_video == "⛔️") {
   save("setting/video.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>"✅",'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
    if ($data == "voice" && $_voice == "✅") {
      save("setting/voice.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>"⛔️",'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "voice" && $_voice == "⛔️") {

	   save("setting/voice.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>"✅",'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "file" && $_file == "✅") {
      save("setting/file.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>"⛔️",'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "file" && $_file == "⛔️") {
	  save("setting/file.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>"✅",'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
     if ($data == "photo" && $_photo == "✅") {
      save("setting/photo.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>"⛔️",'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
     if ($data == "photo" && $_photo == "⛔️") {
	 save("setting/photo.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>"✅",'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
      if ($data == "music" && $_music == "✅") {
      save("setting/music.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>"⛔️",'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
      if ($data == "music" && $_music == "⛔️") {
	       save("setting/music.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>"✅",'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
 
       if ($data == "forward" && $_forward == "✅") {
      save("setting/forward.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>"⛔️",'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
       if ($data == "forward" && $_forward == "⛔️") {

	 save("setting/forward.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>"✅",'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 
      if ($data == "joingp" && $_joingp == "✅") {
      save("setting/joingp.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀
 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>"⛔️",'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
      if ($data == "joingp" && $_joingp == "⛔️") {
	 save("setting/joingp.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀

 🚫 = مقفول
 ✅ = مفتوح",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>"✅",'callback_data'=>"joingp"]
					]
		
                ]
            ])
        ])
    );
 }
 //=========================
}
	
	elseif($textmessage == '')
	{
	//Check Kardan (Media)
	if ($contact  != null && $step== 'Set Contact' && $from_id == $admin) {
	save("profile/number.txt",$cnumber);
	save("profile/cname.txt",$cname);
	SendMessage($chat_id,"تم حفظ الرقم 📞
	*$cname *: `$cnumber`");
	}
	
	if ($photo != null) {
	if ($_photo == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		
		}
	}
	}
	
	if ($sticker != null ) {
		if ($_sticker == "⛔️" && $from_id != $admin) {
	SendMessage($chat_id,"Locked!");
		}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($video != null) {
		if ($from_id != $admin && $_video == "⛔️") {
	SendMessage($chat_id,"Locked!");
		}
		else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($music != null ) {
		if ($from_id != $admin && $_music == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($voice != null) {
		if ($from_id != $admin && $_voice == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($file != null ){
		if ($from_id != $admin && $_file == "⛔️") {
	SendMessage($chat_id,"Locked!");
		}
		
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	elseif ($from_id != $chat_id) {
		
	SendMessage($chat_id,"Bye Bye");
makereq('leaveChat',[
	'chat_id'=>$chat_id
	]);
	}
        
	elseif($textmessage == '🏠 العوده للقائمه السابقه') {
	save($from_id."/step.txt","none");
	if ($type == "admin") {
	
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"*Home : *",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		else {
    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"*Home : *",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    	}
	}
	elseif ($step == 'set word') {
		save($from_id."/step.txt","set answer");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Javb ra vared konid
			Mesal : 
			*Salam Khubi ?*",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
			save("words/$textmessaage.txt","Tarif Nashode !");
			save("last_word.txt",$textmessage);
	}
	elseif ($step == 'set answer') {
		save($from_id."/step.txt","none");
		
		$last = file_get_contents("data/last_word.txt");
			$myfile2 = fopen("data/wordlist.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$last\n");
			fclose($myfile2);
			save("words/$last.txt","$textmessage");
		
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Save Shd
			Yek Gozine Ra Entekhab Konid : 
			",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'اضافه کلمه'],['text'=>'حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		
			
	}
	
	elseif($step == "del words") {
			unlink("data/words/$textmessage.txt");
			var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Delete Shd
			Yek Gozine Ra Entekhab Konid : 
			",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'اضافه کلمه'],['text'=>'حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
			save($from_id."/step.txt","none");
	}
	
		elseif ($step== 'Forward' && $type == 'admin') {
			if ($forward != null) {
			$forward_id = file_get_contents("data/forward_id.txt");
			Forward($forward_id,$chat_id,$message_id);
			save($from_id."/step.txt","none");
			SendMessage($chat_id,"تم التوجيه 🎗");
			}
			else {
				SendMessage($chat_id,"تم توجيه رساله واحده 🎗");
			}
		}
	elseif ($step== 'Set Age' && $type == 'admin') {
	
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Changed",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/age.txt","$textmessage");
	}
	
	elseif ($step== 'Set Name' && $type == 'admin') {
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Changed",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/name.txt","$textmessage");
	}
	
	elseif ($step== 'Set Bio' && $type == 'admin') {
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Changed",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/bio.txt","$textmessage");
	}
	elseif ($step== 'Send To All' && $type == 'admin') {
		SendMessage($chat_id,"Sending Message....");
		save($from_id."/step.txt","none");
		$fp = fopen( "data/users.txt", 'r');
		while( !feof( $fp)) {
 			$users = fgets( $fp);
			SendMessage($users,$textmessage);
		}
		SendMessage($chat_id,"Message Was Sent To All Members!");
		
	}
	elseif ($step== 'Edit Start Text' && $type == 'admin') {
		save($from_id."/step.txt","none");
		save("start_txt.txt",$textmessage);
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"رساله البدء تم تحديثها 🔝",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($step== 'Edit Message Delivery' && $type == 'admin') {
		save($from_id."/step.txt","none");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"رساله الترحيب تم تحديثها 👋",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		save("pmsend_txt.txt",$textmessage);
	}
	
	elseif (file_exists("data/words/$textmessage.txt")) {
		SendMessage($chat_id,file_get_contents("data/words/$textmessage.txt"));
		
	}
	
	elseif ($textmessage == 'ميزات خاصه' && $from_id == $admin) {
		if ($bottype == 'gold') {
			var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"مرحبا بكم في الميزات الخاصه",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'🗣 اعدادات الرد التلقائي'],['text'=>'اعدادات ازرار اضافيه']
                ],
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
        }
		else {
			SendMessage($chat_id,"البوت خاصتك مجاني 😆");
		}
	}
	elseif ($textmessage == 'حذف کلمه' && $from_id == $admin) {
				save($from_id."/step.txt","del words");

		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Kalame Mored Nazar ra vared konid",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	elseif ($textmessage == '🗣 اعدادات الرد التلقائي' && $bottype == 'gold' && $from_id == $admin) {

		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Yek Gozine Ra Entekhab Konid : ",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'اضافه کلمه'],['text'=>'حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		
	}
	elseif ($textmessage == 'اضافه کلمه' && $bottype == 'gold' && $from_id == $admin) {
				save($from_id."/step.txt","set word");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Kalame Aval ra vared konid
			Mesal : 
			*Salam*",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				
                 [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '▶️ ضبط رساله البدء' && $from_id == $admin) {
	$sttxt = file_get_contents("data/start_txt.txt");
	save($from_id."/step.txt","Edit Start Text");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"*تغيير نص البدء*
	النص الحالي هو : 
	`".$sttxt."`
	يرجى كتابه نص بدء جديد ♥",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '⏸ ضبط رساله الترحيب' && $from_id == $admin) {
	$sttxt = file_get_contents("data/pmsend_txt.txt");
	save($from_id."/step.txt","Edit Message Delivery");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"*نص تغيير تسليم الرساله*
	النص الحالي هو : 
	`".$sttxt."`
	يرجى كتابة نص جديد لرسالة التسليم ♥",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '⚙ اعدادات' && $from_id == $admin) {
	
	var_dump(makereq('sendMessage',[
			'chat_id'=>$update->message->chat->id,
			'text'=>"اهلا بك عزيزي في قائمة الاعدادات🌀
`
 🚫 = مقفول
 ✅ = مفتوح"."`",
			'parse_mode'=>'MarkDown',
			'reply_markup'=>json_encode([
				'inline_keyboard'=>[
					[
						['text'=>"استلام الملصقات",'callback_data'=>"sticker"],['text'=>$_sticker,'callback_data'=>"sticker"]
					],
					[
						['text'=>"استلام الفديو",'callback_data'=>"video"],['text'=>$_video,'callback_data'=>"video"]
					],
					[
						['text'=>"استلام الصوت",'callback_data'=>"voice"],['text'=>$_voice,'callback_data'=>"voice"]
					],
					[
						['text'=>"استلام الملفات",'callback_data'=>"file"],['text'=>$_file,'callback_data'=>"file"]
					],
					[
						['text'=>"استلام الصور",'callback_data'=>"photo"],['text'=>$_photo,'callback_data'=>"photo"]
					],
					[
						['text'=>"استلام الاغاني",'callback_data'=>"music"],['text'=>$_music,'callback_data'=>"music"]
					],
					[
						['text'=>"استلام توجيه",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					],
					[
						['text'=>"اضافة البوت",'callback_data'=>"joingp"],['text'=>$_joingp,'callback_data'=>"joingp"]
					]
				]
			])
		]));
	
	}
	
	elseif ($textmessage == '👁 إظهار رقم هاتفي' && $from_id == $admin) {
	$anumber = file_get_contents("data/profile/number.txt");
	$aname= file_get_contents("data/profile/cname.txt");
	makereq('sendContact',[
	'chat_id'=>$chat_id,
	'phone_number'=>$anumber,
	'first_name'=>$aname
	]);
	}
	elseif ($textmessage == 'عمرك' && $from_id == $admin) {
	save($from_id."/step.txt","Set Age");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Please Write Your Age Now!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == 'اسمك' && $from_id == $admin) {
	save($from_id."/step.txt","Set Name");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Please Write Your Name Now!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == 'امور عنك' && $from_id == $admin) {
	save($from_id."/step.txt","Set Bio");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Please Write Your Biography Now!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '☎️  اعدادات الاتصال' && $from_id == $admin) {
	save($from_id."/step.txt","Set Contact");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"حدد احد الخيارات التاليه 🔦",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🌐 تعيين رقم الهاتف' , 'request_contact' => true]
                ],
              	[
                   ['text'=>'👁 إظهار رقم هاتفي']
                ],
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '👥 المشتركين' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"*Users :* `".$usercount."`");
	}
	
	elseif ($textmessage == '⚫️ قائمة المحضورين' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/blocklist.txt", 'r');
	while( !feof( $fp)) {
    		$line = fgets( $fp);
    		$usercount ++;	
			
			if ($line == '') {
				$usercount = $usercount-1;
			}
	}
	fclose( $fp);
	SendMessage($chat_id,"*Blocked Users :* `".$usercount."`");
	}
	
	elseif ($textmessage == 'ترقية البوت' && $from_id == $admin) {
	$text = "
	💥 يمكن تحويل بوتك الى شخصية(VIP) بشروط! 💥
➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖
✅ ميزات فوق العاده سوف تتمتع بها ومنها! 📈

1⃣ حذف جميع الاعلانات الموجوده في البوت ❌
2⃣ تحكم كامل للازرار الشفافه بالبوت ⌨
3⃣ رفع جميع المشاكل بالنسبه للنسخ الاحتياطي 🗣
الشروط : 
4⃣ يجب عليك اولا مراجعة الدعم الفني \n@kenamch 😉
5⃣ طلب الترقيه الى عضوية VIP من قبل المطور 🤖

🔰 لترقية بوتك الى عضوية (VIP) عليك دفع رسوم 2$ رصيد فقط
";
	SendMessage($chat_id,$text);
	}
	
	elseif ($textmessage == '⚓️ مساعده' && $from_id == $admin) {
	$text = "
	مرحبا 🤗

-هذا البوت صنع لراحتکم وللاطلاع علی بوت،قناه،مجموعه او موقع

- مکتوب بلغه PHP

- مبرمج البوت : @saad7m

ل مشاهده الاوامر اختر احد الازرار التاليه👇

Copy Right 2017 ©
@kenamch
	";
	
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>$text,
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔰 الاوامر"],['text'=>"🔰 الرئيسيه"]
                ],
                [ 
                 ['text'=>"🏠 العوده للقائمه السابقه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	elseif ($textmessage == '👤 پروفایل') {
		if ($from_id == $admin) {
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"إدارة ملف التعريف الخاص بك",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"اسمك"],['text'=>"عمرك"],['text'=>"امور عنك"]
                ],
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
		else {
			$name = file_get_contents("data/profile/name.txt");
			$age = file_get_contents("data/profile/age.txt");
			$bio = file_get_contents("data/profile/bio.txt");
			$protxt = "";
			if ($name == '' && $age == '' && $bio == '') {
				$protxt = "📕 الملف الشخصي خالي . . . !";
			}
			if ($name != '') {
				$protxt = $protxt."\nName : ".$name;
			}
			
			if ($age != '') {
				$protxt = $protxt."\nAge : ".$age;
			}
			
			if ($bio != '') {
				$protxt = $protxt."\nBioGraphy : \n".$bio;
			}
			SendMessage($chat_id,$protxt);
		}
	}
	elseif ($textmessage == '🔰 الاوامر' && $from_id == $admin) {
	$text = " `
	🔰الاوامر

-  للرد علی رسائل الاعضاء قم بعمل الرد (ریبلای) للعضو وارسل رسالتک

+ قائمة الاوامر

  /ban : 
قم بل رد علی الرساله وارسل  ban/ 
 ل اضافة العضو الی قائمه  المحضورين


  /unban : 
 قم بلرد علی الرساله وارسل   unban/ 
 لحذف العضو من قائمة المحضورين

  /forward : 
قم بلرد علی الرساله وارسل  forward/ 
 لتوجیه الرساله الی العضو 
 قم بلرد علی الرساله و ارسل forward/  ثم ارسل الرساله التی تود توجیهها


  /share :  
قم بلرد علی الرساله وارسل  share/ 
 لاشتراک الاتصال (رقمک) یلزم ان تثبت رقمک فی قسمة الاعدادات
	`";
	SendMessage($chat_id,$text);
	}
	
	elseif ($textmessage == '🔰 الرئيسيه' && $from_id == $admin) {
	$text = "
	🔰الازرار الرئيسيه 

+ Buttons List

  🗣 رساله عامه :
 ارسال رساله للاعضاء والمجموعات

  ⚙ اعدادات:
   لاضهار اعدادات البوت

  ▶️ ضبط رساله البدء:
  ضبط رساله البدءللاعضاء عند دخول البوت

  ⏸ ضبط رساله الترحيب:
  ضبط رساله ارسال الاعضاء لك

  👥 المشتركين:
  مشاهده كل الاعضاء المشتركين

  ⚫️ قائمة المحضورين:
  مشاهده  قائمة المحضورين

  ☎️  اعدادات الاتصال:
   اعدادات رقم الهاتف خاصتك

  👤 پروفایل :
  اعدادات معلومات صفحتك الشخصيه
	";
	SendMessage($chat_id,$text);
	}
	
	elseif($textmessage == '/start')
	{
		$txt = file_get_contents("data/start_txt.txt");
		//==============
		if ($type == "admin") {
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"مرحبا بك في الروبوت الخاص بك 😊🍃",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🗣 رساله عامه"],['text'=>"⚓️ مساعده"],['text'=>"⚙ اعدادات"]
                ],
                [
                   ['text'=>"▶️ ضبط رساله البدء"],['text'=>"⏸ ضبط رساله الترحيب"]
                ],
                [
                   ['text'=>"👥 المشتركين"],['text'=>"ترقية البوت"],['text'=>"⚫️ قائمة المحضورين"]
                ],
                [
                   ['text'=>"☎️  اعدادات الاتصال"],['text'=>"👤 پروفایل"],['text'=>"ميزات خاصه"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		else {
    		if ($bottype != "gold") {

    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>$txt."\n\nCreate Your Own Bot With @mchenbot",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		else {
    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>$txt,
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		}
		//==============
		$users = file_get_contents("data/users.txt");
		if (strpos($users , "$chat_id") !== false)
		{ 
		
		}
		else { 
			$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$from_id\n");
			fclose($myfile2);
			mkdir("data/".$from_id);
			save($from_id."/type.txt","member");
			save($from_id."/step.txt","none");
		     }
	}
	elseif ($reply != null && $from_id == $admin) {
		if ($textmessage == '/share') {
		$anumber = file_get_contents("data/profile/number.txt");
		$aname= file_get_contents("data/profile/cname.txt");
		makereq('sendContact',[
		'chat_id'=>$reply,
		'phone_number'=>$anumber,
		'first_name'=>$aname
		]);
		SendMessage($chat_id,"تم الارسال 👍");
		}
		elseif ($textmessage == '/forward') {
		SendMessage($chat_id,"يتم تمرير الرساله 👍");	
		save($from_id."/step.txt","Forward");
		save("forward_id.txt","$reply");
		}
		elseif ($textmessage == '/ban') {
			$myfile2 = fopen("data/blocklist.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$reply\n");
			fclose($myfile2);
			SendMessage($chat_id,"*User Banned!*");
			SendMessage($reply,"*You Are Banned!*");
		}
		elseif ($textmessage == '/unban') {
			
			$newlist = str_replace($reply,"",$list);
			save("blocklist.txt",$newlist);
			SendMessage($chat_id,"*User UnBanned!*");
			SendMessage($reply,"*You Are UnBanned!*");
		}
		else {
	SendMessage($reply ,$textmessage);
	SendMessage($chat_id,"تم الارسال 👍");	
		}
	}
	
	elseif ($textmessage == '/creator' && $bottype != "gold") {
    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Create Your Own Bot With @mchenbot",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		
	}
	elseif ($forward != null && $_forward == "⛔️") {
		SendMessage($chat_id,"Locked!");
	}
	elseif (strpos($textmessage , "/toall") !== false  || $textmessage == "🗣 رساله عامه") {
		if ($from_id == $admin) {
			save($from_id."/step.txt","Send To All");
				var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"Write Your Text!",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 العوده للقائمه السابقه']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
		else {
			SendMessage($chat_id,"You Are Not Admin");
		}
	}
	else
	{
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		SendMessage($chat_id,"Command Not Found!");
		}
	}
	
	
	?>