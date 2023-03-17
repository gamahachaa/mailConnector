package;
import haxe.Json;
import haxe.crypto.Base64;
import mail.Params;
import mail.Results;
import php.Lib;
import php.Syntax;
import php.Web;

/**
 * ...
 * @author bb
 */
typedef Result =
{
	var status:String;
	var error:Dynamic;
	var additional:String;
	var ?debug:String;
}
class TSMailer
{
	var transport:Dynamic;
	var mailer:Dynamic;
	var body:Dynamic;
	var route:String;
	var params:haxe.ds.Map<String, String>;
	var message:Dynamic;
	var shouldSend:Bool;
	var _result:Result;
	//static inline var SUBJECT:String = "subject";
	//static inline var BODY:String = "body";
	//static inline var BCC_EMAIL:String = "bcc_email";
	//static inline var CC_EMAIL:String = "cc_email";
	//static inline var TO_EMAIL:String = "to_email";
	//static inline var TO_FULL_NAME:String = "to_full_name";

	public function new()
	{
		
		// init
		createSwiftMailer();
		//_result = {status: "failed", error : "", additional : ""};
		_result = {status: Results.FAILED, error : null, additional : "", debug:""};

		route = Web.getURI();
		params = Web.getParams();
		shouldSend = true;
		message = Syntax.construct("Swift_Message", "ERRORED");

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		if (params.exists(Params.SUBJECT))
		{
			try
			{
				prepareTo();
				// non blocking
				prepareFrom();
				prepareCc();
				prepareBcc();
				prepareImage();
				prepareBody(prepareImage());
				_result.additional = params.get(Params.SUBJECT);
				_result.debug = params.get(Params.SUBJECT);
				message = prepareSubject(params.get(Params.SUBJECT));
				_result.debug = message;

			}
			catch (e)
			{
				_result.debug = e.message;
			}

		}
		else
		{
			shouldSend = false;
			_result.additional += "No subject; ";
		}

		if (shouldSend)
		{

			var result = Syntax.call(mailer, "send", message);
			if (result)
			{
				_result.status = "success";
				//_result.error = "";
				//Lib.print("{status:'success'}");
			}
			else
			{
				_result.status = "failed";
				_result.error = "transport issue";
				//Lib.print("{status:'failed',error:'transport issue'}");
			}
			#if debug
			#end
		}
		else
		{
			_result.status = "failed";
			_result.error = "missing key variable";
			//Lib.print("{status:'failed',error:'missing key variable'}");
		}
		Lib.print(Json.stringify( _result ) );
	}

	function prepareBody(?image = null)
	{
		if (params.exists(Params.BODY))
		{
			var body = params.get(Params.BODY);
			if (image != null)
			{
				var img = '<img src="$image" alt="Image"/>';
				body = if (params.exists(Params.STRING_TO_REPLACE))
				{
					StringTools.replace(body, params.get(Params.STRING_TO_REPLACE),  img);
				}
				else{
					StringTools.replace(body, "</body>", img + "</body>");
				}
			}
			else{
				 StringTools.replace(body, params.get(Params.STRING_TO_REPLACE), "");
			}
			Syntax.call(message, "setBody", body, "text/html");
		}
		else
		{
			shouldSend = false;
			_result.additional += " No BODY; ";
		}
	}

	function prepareBcc()
	{
		var bcc = {};
		if (params.exists(Params.BCC_EMAIL))
		{
			var t = params.get(Params.BCC_EMAIL).split(",");
			for (i in t)
			{
				Reflect.setField(bcc, i, "" );
			}
			//Reflect.setField(bcc, params.get("bcc_email"), params.exists("bcc_full_name") ? params.get("bcc_full_name") : "" );
			Syntax.call(message, "setBcc", Lib.associativeArrayOfObject(bcc));
		}
	}

	function prepareCc()
	{
		var cc = {};
		if (params.exists(Params.CC_EMAIL))
		{
			var t = params.get(Params.CC_EMAIL).split(",");

			//Reflect.setField(cc, params.get("cc_email"), params.exists("cc_full_name") ? params.get("cc_full_name") : "" );
			for (i in t)
			{
				Reflect.setField(cc, i, "" );
			}
			Syntax.call(message, "setCc", Lib.associativeArrayOfObject(cc));
		}
	}

	function prepareTo()
	{
		var to = {};
		if (params.exists(Params.TO_EMAIL))
		{
			Reflect.setField(to, params.get(Params.TO_EMAIL), params.exists(Params.TO_FULL_NAME) ? params.get(Params.TO_FULL_NAME): "");
			Syntax.call(message, "setTo", Lib.associativeArrayOfObject(to));
		}
		else
		{
			shouldSend = false;
			_result.additional += " No TO; ";
		}
	}

	function prepareFrom()
	{
		var from = {};

		if (!params.exists(Params.FROM_MAIL))
		{
			params.set(Params.FROM_MAIL, "qook@salt.ch");
			params.set("from_full_name", "qook troubleshoooting");
		}
		Reflect.setField(from, params.get(Params.FROM_MAIL), params.exists("from_full_name") ? params.get("from_full_name") : "" );
		//Syntax.call(message, "setFrom", Lib.associativeArrayOfObject(from));
		Syntax.call(message, "setFrom", from);
	}

	function prepareSubject(s:String)
	{
		//return Syntax.construct("Swift_Message", params.get(SUBJECT));
		return Syntax.construct("Swift_Message", s);
	}
	function prepareImage()
	{
		var embeded:Dynamic = null;
		if (this.params.exists(Params.IMAGE))
		{
            var ext = params.exists(Params.IMAGE_EXT) ? params.get(Params.IMAGE_EXT): "image/png";
			var imgData =  Base64.decode(params.get(Params.IMAGE));
			var swiftImage = Syntax.construct("Swift_Image", imgData , ext );
			embeded = Syntax.call(message, "embed", swiftImage);
			
		}
		return embeded;
	}

	inline function createSwiftMailer():Void
	{
		// call framework SwiftMAiler (symphony as PHP)
		Syntax.code("require_once({0})", "vendor/autoload.php");
		// set tup
		transport = Syntax.construct("Swift_SmtpTransport", 'smtp.salt.ch', 25);
		Syntax.call(transport, "setUsername", "bbaudry" );
		//Syntax.call(transport, "setPassword", "1234" );

		mailer = Syntax.construct("Swift_Mailer", transport);
	}

}