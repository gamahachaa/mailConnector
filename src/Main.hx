package;

import haxe.Json;
import php.Lib;
import TSMailer;

/**
 * ...
 * @author bbaudry
 */
class Main
{

	static function main()
	{
		var m:Main = new Main();
	}
	public function new ()
	{
		var result:Result = {status:"failed", error:null, additional:"initial"};
		try{
			var mailer:TSMailer = new TSMailer();
		}
		catch(e:Dynamic)
		{
			result.error = e;
			Lib.print(Json.stringify(result));
		}
	}
}
