function Serialize(obj) {
	if (obj == null)
		return null;
	switch (obj.constructor) {
	case Object:
		var str = "{";
		for ( var o in obj) {
			str += o + ":" + Serialize(obj[o]) + ",";
		}
		if (str.substr(str.length - 1) == ",")
			str = str.substr(0, str.length - 1);
		return str + "}";
		break;
	case Array:
		var str = "[";
		for ( var o in obj) {
			str += Serialize(obj[o]) + ",";
		}
		if (str.substr(str.length - 1) == ",")
			str = str.substr(0, str.length - 1);
		return str + "]";
		break;
	case Boolean:
		return "\"" + obj.toString() + "\"";
		break;
	case Date:
		return "\"" + obj.toString() + "\"";
		break;
	case Function:
		break;
	case Number:
		return "\"" + obj.toString() + "\"";
		break;
	case String:
		return "\"" + obj.toString() + "\"";
		break;
	}
}

function SafeAjax(options) {
	$.ajax(options);
}
