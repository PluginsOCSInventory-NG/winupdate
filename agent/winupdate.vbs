'----------------------------------------------------------
' Plugin for OCS Inventory NG 2.x
' Script :		Retrieve Windows Update Status (W10), included last updates detected, download and installed (XP, W7, W8.1)
' Version :		2.00
' Date :		11/08/2017
' Authors :		Guillaume PRIOU and Stéphane PAUTREL (acb78.com)
'----------------------------------------------------------
' OS checked [X] on	32b	64b	(Professionnal edition)
' Windows XP		[X]	[ ]
' Windows 7		[X]	[X]
' Windows 8.1		[X]	[X]	
' Windows 10		[X]	[X]
' ---------------------------------------------------------
' NOTE : No checked on Windows Vista and Windows 8
' Degree of user interaction (AUOptions)
	'1 = Disables AU (Same as disabling it through the standard controls)
	'2 = Notify Download and Install (Requires Administrator Privileges)
	'3 = Notify Install (Requires Administrator Privileges)
	'4 = Automatically, no notification (Uses ScheduledInstallTime and ScheduledInstallDay)
' ---------------------------------------------------------
On Error Resume Next

Const HKEY_LOCAL_MACHINE = &H80000002
Dim objAutoUpdate, objAUSettings, strRegistry, Result

Set objWMIService = GetObject("winmgmts:" & "{impersonationLevel=impersonate}!\\.\root\cimv2")
Set colOperatingSystems = objWMIService.ExecQuery ("Select * from Win32_OperatingSystem")

For Each objOperatingSystem in colOperatingSystems
	If InStr(objOperatingSystem.version,"10.0.")<>0  Then
		strOS = 10
	End If
Next

' Common method for AUOptions
Set objAutoUpdate = CreateObject("Microsoft.Update.AutoUpdate")
Set objAUSettings = objAutoUpdate.Settings

strRegistry = "Software\Microsoft\Windows\CurrentVersion\WindowsUpdate\Auto Update"

' Windows update status (degree of user interaction)
Result = "<WINUPDATESTATE>" & VbCrLf & "<AUOPTIONS>" &_
    objAUSettings.NotificationLevel & "</AUOPTIONS>"

' Last success update install date
Result = Result & VbCrLf & "<LASTSUCCESSTIME>" &_
    ReadRegStr (HKEY_LOCAL_MACHINE, strRegistry & "\Results\Install\", "LastSuccessTime", 64) & "</LASTSUCCESSTIME>"

' Last success update detected date
Result = Result & VbCrLf & "<DETECTSUCCESSTIME>" &_
    ReadRegStr (HKEY_LOCAL_MACHINE, strRegistry & "\Results\Detect\", "LastSuccessTime", 64) & "</DETECTSUCCESSTIME>"

' Last success update downloaded date
Result = Result & VbCrLf & "<DOWNLOADSUCCESSTIME>" &_
    ReadRegStr (HKEY_LOCAL_MACHINE, strRegistry & "\Results\Download\", "LastSuccessTime", 64) & "</DOWNLOADSUCCESSTIME>"

' Retrieve next verification of Windows update
Result = Result & VbCrLf & "<SCHEDULEDINSTALLDATE>" &_
    ReadRegStr (HKEY_LOCAL_MACHINE, strRegistry, "ScheduledInstallDate", 64) & "</SCHEDULEDINSTALLDATE>"

Result = Result & VbCrLf & "</WINUPDATESTATE>"

Function ReadRegStr (RootKey, Key, Value, RegType)
	Dim oCtx, oLocator, oReg, oInParams, oOutParams

	Set oCtx = CreateObject("WbemScripting.SWbemNamedValueSet")
	oCtx.Add "__ProviderArchitecture", RegType

	Set oLocator = CreateObject("Wbemscripting.SWbemLocator")
	Set oReg = oLocator.ConnectServer("", "root\default", "", "", , , , oCtx).Get("StdRegProv")

	Set oInParams = oReg.Methods_("GetStringValue").InParameters
		oInParams.hDefKey = RootKey
		oInParams.sSubKeyName = Key
		oInParams.sValueName = Value

	Set oOutParams = oReg.ExecMethod_("GetStringValue", oInParams, , oCtx)
	ReadRegStr = oOutParams.sValue
	If IsNull(oOutParams.sValue) and strOS = 10 Then
		ReadRegStr = "Auto"
	End If
End Function

Wscript.Echo Result
