var Debug = {
	TraceWindowID : "TraceWindow",
	TraceQueueID : "TraceQueue",
	LineCount : 0,
	
	Trace : function(msg){
		var traceQueue = (!document.getElementById(this.TraceQueueID)) ? this.CreateTraceWindow() : document.getElementById(this.TraceQueueID);
		var traceItem = this.CreateTraceItem(msg);
		traceQueue.insertBefore(traceItem, traceQueue.childNodes[0]);
	},
	
	CreateTraceItem : function(msg){
		this.LineCount++;
		var timeStamp = "[" + this.TimeStamp() + "] ";
		var li = document.createElement("li");
		li.className = "highlight" + this.LineCount%2;
		li.appendChild(document.createTextNode(timeStamp));
		li.appendChild(document.createTextNode(msg));
		return li
	},
	
	CreateTraceWindow : function(){
		var traceWindow = document.createElement("div");
		var position = (document.all) ? "absolute" : "fixed";
		traceWindow.id = this.TraceWindowID;
		traceWindow.style.position = position;
		traceWindow.style.top = (document.all) ? document.body.scrollTop + "px" : "0px";
		traceWindow.style.left = (document.all) ? document.body.scrollLeft + "px" : "0px";
		var traceQueue = document.createElement("ul");
		traceQueue.id = this.TraceQueueID;
		var traceItem = this.CreateTraceItem("Trace Initialized");
		traceItem.className = "initialized";
		traceQueue.appendChild(traceItem);
		traceWindow.appendChild(traceQueue);
		document.body.insertBefore(traceWindow, document.body.childNodes[0]);
		return traceQueue
	},
	
	TimeStamp : function(){
		var dt = new Date();
		var hrs = this.ToDoubleDigit(dt.getHours());
		var mins = this.ToDoubleDigit(dt.getMinutes());
		var secs = this.ToDoubleDigit(dt.getSeconds());
		return hrs + ":" + mins + ":" + secs
	},
	
	ToDoubleDigit : function(num){
		return (num < 10) ? "0" + num.toString() : num;
	}
}