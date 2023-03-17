package;
import haxe.Json;
import mail.Params;
import mail.Results;
//import mail.Params;
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
		if (params.exists(Params.SUBJECT))
		{
			_result.additional = params.get(Params.SUBJECT);
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
				_result.status = Results.SUCCESS;
				_result.error = "";
				//Lib.print("{status:'success'}");
			}
			else
			{
				_result.status = Results.FAILED;
				_result.error = "transport issue";
				//Lib.print("{status:'failed',error:'transport issue'}");
			}
			#if debug
			#end
		}
		else
		{
			_result.status = Results.FAILED;
			_result.error = "missing key variable";
			//Lib.print("{status:'failed',error:'missing key variable'}");
		}
		Lib.print(Json.stringify( _result ) );
	}

	function prepareBody()
	{
		if (params.exists(Params.BODY))
		{
			Syntax.call(message, "setBody", params.get(Params.BODY), "text/html");
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
		Reflect.setField(from, params.get(Params.FROM_MAIL), params.exists(Params.FROM_FULL_MAIL) ? params.get(Params.FROM_FULL_MAIL) : "" );
		Syntax.call(message, "setFrom", Lib.associativeArrayOfObject(from));
	}

	function prepareSubject()
	{
		return Syntax.construct("Swift_Message", params.get(Params.SUBJECT));
	}

}