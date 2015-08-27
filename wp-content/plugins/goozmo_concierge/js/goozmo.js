var Comm100API = Comm100API || new Object;
Comm100API.chat_buttons = Comm100API.chat_buttons || [];

var comm100_chatButton = new Object;
comm100_chatButton.code_plan = 2629;
comm100_chatButton.div_id = 'comm100-button-2629';
Comm100API.chat_buttons.push(comm100_chatButton);
Comm100API.site_id = 127187;
Comm100API.main_code_plan = 2629;
    
var comm100_lc = document.createElement('script');
comm100_lc.type = 'text/javascript';
comm100_lc.async = true;
comm100_lc.src = 'https://chatserver.comm100.com/livechat.ashx?siteId=' + Comm100API.site_id;

var comm100_s = document.getElementsByTagName('script')[0];
comm100_s.parentNode.insertBefore(comm100_lc, comm100_s);