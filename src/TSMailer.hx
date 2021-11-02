package;
import haxe.Json;
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
	var error:String;
	var additional:String;
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

	public function new()
	{
		_result = {status: "failed", error : "", additional : ""};
		Syntax.code("require_once({0})", "vendor/autoload.php");
		transport = Syntax.construct("Swift_SmtpTransport", 'smtp.salt.ch', 25);
		Syntax.call(transport, "setUsername", "bbaudry" );
		//Syntax.call(transport, "setPassword", "Saa..t33" );

		mailer = Syntax.construct("Swift_Mailer", transport);
		
		

		route = Web.getURI();
		params = Web.getParams();
		shouldSend = true;
		
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		if (params.exists("subject"))
		{
			_result.additional = params.get("subject");
			message = prepareSubject();
			prepareBody();
			prepareTo();
			// non blocking
			prepareFrom();
			prepareCc();
			prepareBcc();
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
				_result.error = "";
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

	function prepareBody()
	{
		if (params.exists("body"))
		{
			Syntax.call(message, "setBody", params.get("body"), "text/html");
		}
		else
		{
			shouldSend = false;
			_result.additional += "No BODY; ";
		}
	}

	function prepareBcc()
	{
		var bcc = {};
		if (params.exists("bcc_email"))
		{
			var t = params.get("bcc_email").split(",");
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
		if (params.exists("cc_email"))
		{
			var t = params.get("cc_email").split(",");
			
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
		if (params.exists("to_email"))
		{
			Reflect.setField(to, params.get("to_email"), params.exists("to_full_name") ? params.get("to_full_name"): "");
			Syntax.call(message, "setTo", Lib.associativeArrayOfObject(to));
		}
		else
		{
			shouldSend = false;
			_result.additional += "No TO; ";
		}
	}

	function prepareFrom()
	{
		var from = {};

		if (!params.exists("from_email"))
		{
			params.set("from_email", "qook@salt.ch");
			params.set("from_full_name", "qook troubleshoooting");
		}
		Reflect.setField(from, params.get("from_email"), params.exists("from_full_name") ? params.get("from_full_name") : "" );
		Syntax.call(message, "setFrom", Lib.associativeArrayOfObject(from));
	}

	function prepareSubject()
	{
		return Syntax.construct("Swift_Message", params.get("subject"));
	}

}