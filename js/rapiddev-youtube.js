/**
 * YouTube Pro
 * ------------
 * Version : 1.3.0
 * Website : http://wordpress.org/plugins/rapiddev-youtube/
 * Repo    : https://github.com/RapidDTC/YouTube-Pro
 * Author  : RapidDev
 */
 function rapiddev_youtube_broadcasts(video, type, error, type_live, type_completed){
	var xmlhttp;
	if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var response =  JSON.parse(xmlhttp.responseText)
				if (typeof response['pageInfo']['totalResults'] !== 'undefined') {
					if(type == 'live'){
						var button_title = type_live;
					}else{
						var button_title = type_completed;
					}
					video.innerHTML = "<img alt=\""+response['items'][0]['snippet']['title']+"\" style=\"width:auto;height:auto;max-width:100%;\" src=\""+response["items"][0]["snippet"]["thumbnails"]["medium"]["url"]+"\"/><h5 id=\"live_"+i+"\" style=\"margin-top:0;padding-top:0\">"+response["items"][0]["snippet"]["title"]+"</h5><a href=\"https://www.youtube.com/watch?v="+response["items"][0]["id"]["videoId"]+"\" target=\"_blank\" rel=\"noopener norefferer\">"+button_title+"</a>";
				}
		}else{
			if (!document.getElementById("live_"+i)) {
				if (type == 'live') {
					rapiddev_youtube_broadcasts(video, 'completed', error, type_live, type_completed);
				}else{
					video.innerHTML = error;
				}
			}
		}
	}
	xmlhttp.open("GET", "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId="+video.getAttribute("channel")+"&maxResults=1&order=date&type=video&eventType="+type+"&key="+video.getAttribute("api-key"), true);
	xmlhttp.send();
}
function rapiddev_youtube_latestvideos(video, error, type_latest){
	var xmlhttp;
	if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var response =  JSON.parse(xmlhttp.responseText);
				if (typeof response['items'][0]['snippet']['title'] !== 'undefined') {
					video.innerHTML = "<img alt=\""+response['items'][0]['snippet']['title']+"\" style=\"width:auto;height:auto;max-width:100%;\" src=\""+response["items"][0]["snippet"]["thumbnails"]["medium"]["url"]+"\"/><h5 style=\"margin-top:0;padding-top:0\">"+response["items"][0]["snippet"]["title"]+"</h5><a href=\"https://www.youtube.com/watch?v="+response["items"][0]["id"]["videoId"]+"\" target=\"_blank\" rel=\"noopener norefferer\">"+type_latest+"</a>";
				}
		}else{
			video.innerHTML = error;
		}
	}
	xmlhttp.open("GET", "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId="+video.getAttribute("channel")+"&maxResults=1&order=date&type=video&key="+video.getAttribute("api-key"), true);
	xmlhttp.send();
}