'Date : Le 29/12/2012
'Autor : Guillaume PRIOU
'Retrieve Windows Update Status, lasts updates detected, download and installed
'--------------------------------------------

On error resume next
Wscript.Echo "<WINUPDATESTATE>"
set c=CreateObject("WScript.Shell" )
'Retrieve the degree of user interaction
    '1 = Disables AU (Same as disabling it through the standard controls)
    '2 = Notify Download and Install (Requires Administrator Privileges)
    '3 = Notify Install (Requires Administrator Privileges)
    '4 = Automatically, no notification (Uses ScheduledInstallTime and ScheduledInstallDay)

AutoUpdateLevel = c.RegRead("HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update\AUOptions")
Wscript.Echo "<AUOPTIONS>"& AutoUpdateLevel &"</AUOPTIONS>"
 
'Retrieve next verification of windows update
ScheduledInstallDate = c.RegRead("HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update\ScheduledInstallDate")
Wscript.Echo "<SCHEDULEDINSTALLDATE>"& ScheduledInstallDate &"</SCHEDULEDINSTALLDATE>"
 
'Last success update install date 
LastSuccessTime = c.RegRead("HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update\Results\Install\LastSuccessTime")
Wscript.Echo "<LASTSUCCESSTIME>"& LastSuccessTime &"</LASTSUCCESSTIME>"
'Last success update detected date
DetectSuccessTime = c.RegRead("HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update\Results\Detect\LastSuccessTime")
Wscript.Echo "<DETECTSUCCESSTIME>"& DetectSuccessTime &"</DETECTSUCCESSTIME>"
'Last success update downloaded date
DownloadSuccessTime = c.RegRead("HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update\Results\Download\LastSuccessTime")
Wscript.Echo "<DOWNLOADSUCCESSTIME>"& DownloadSuccessTime &"</DOWNLOADSUCCESSTIME>"
Wscript.Echo "</WINUPDATESTATE>"