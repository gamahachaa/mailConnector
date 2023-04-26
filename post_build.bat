%1

set BINDIR=%cd%\bin\
echo %BINDIR%
if "%1"==""  goto :dead
if "%1"=="debug"  goto :end


 "C:\_mesProgs\WinSCP\WinSCP.com" ^
   /log="%cd%\WinSCP.log" /ini=nul ^
   /command ^
     "open sftp://qook:uU155cy54IGQf0M4Jek6@10.192.14.13/ -hostkey=""ssh-rsa 2048 nqlUJZBRZk4+gCB8pRNrGcXJrx13iKLTftGfrXlqvk4=""" ^
     "lcd %BINDIR%lib" ^
 "cd /home/qook/app/qook/commonlibs/mail/lib" ^
     "put -nopreservetime *" ^
     "exit"
	
 "C:\_mesProgs\WinSCP\WinSCP.com" ^
   /log="%cd%\WinSCP.log" /ini=nul ^
   /command ^
     "open sftp://qook:uU155cy54IGQf0M4Jek6@10.192.14.13/ -hostkey=""ssh-rsa 2048 nqlUJZBRZk4+gCB8pRNrGcXJrx13iKLTftGfrXlqvk4=""" ^
     "lcd %BINDIR%" ^
     "cd /home/qook/app/qook/commonlibs/mail" ^
     "put -nopreservetime index.php" ^
     "exit"
goto :completed

if "%1"!="debug"  goto :dead

:end


"C:\_mesProgs\WinSCP\WinSCP.com" ^
  /log="%cd%\WinSCP.log" /ini=nul ^
  /command ^
    "open sftp://qook:uU155cy54IGQf0M4Jek6@10.193.14.13/ -hostkey=""ssh-rsa 2048 wS00k9P56QO60lm1NS8bO+nPtjNA0htnzu/XzCyhfQg=""" ^
    "lcd %BINDIR%lib" ^
    "cd /home/qook/app/qook/commonlibs/mail/lib" ^
    "put -nopreservetime *" ^
    "exit"
	
"C:\_mesProgs\WinSCP\WinSCP.com" ^
  /log="%cd%\WinSCP.log" /ini=nul ^
  /command ^
    "open sftp://qook:uU155cy54IGQf0M4Jek6@10.193.14.13/ -hostkey=""ssh-rsa 2048 wS00k9P56QO60lm1NS8bO+nPtjNA0htnzu/XzCyhfQg=""" ^
    "lcd %BINDIR%" ^
    "cd /home/qook/app/qook/commonlibs/mail" ^
    "put -nopreservetime index.php" ^
    "exit"
goto :completed
	
:dead
	
echo "compile directive not found"

:completed