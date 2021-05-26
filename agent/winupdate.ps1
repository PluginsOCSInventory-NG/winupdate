function Get-Operation{
    param([int] $operation)
    switch ($operation) {
        1 { "Installation" }
        2 { "Uninstallation" }
        3 { "Other" }
    }
}

function Get-Status{
    param([int] $status)
    switch ($status) {
        1 { "In progess" }
        2 { "Succeeded" }
        3 { "Succeeded with errors" }
        4 { "Failed" }
        5 { "Aborted" }
    }
}

$Session = New-Object -ComObject "Microsoft.Update.Session"
$Searcher = $Session.CreateUpdateSearcher()
$historyCount = $Searcher.GetTotalHistoryCount()

$UpdateHistory = $Searcher.QueryHistory(0, $historyCount) | Select *

foreach ($Update in $UpdateHistory) { 
    [regex]::match($Update.Title,'(KB[0-9]{6,7})').value | Where-Object {$_ -ne ""} | foreach { 
        $op = Get-Operation($Update.Operation)
        $stat = Get-Status($Update.ResultCode)
        $xml += "<WINUPDATESTATE>`n"
        $xml += "<KB>" + $_ + "</KB>`n"
        $xml += "<TITLE>" + $Update.Title + "</TITLE>`n"
        $xml += "<DATE>" + $Update.Date + "</DATE>`n"
        $xml += "<OPERATION>" + $op + "</OPERATION>`n"
        $xml += "<STATUS>" + $stat + "</STATUS>`n"
        $xml += "<SUPPORTLINK>" + $Update.SupportUrl + "</SUPPORTLINK>`n"
        $xml += "<DESCRIPTION>" + $Update.Description + "</DESCRIPTION>`n"
        $xml += "</WINUPDATESTATE>`n"
    } 
}

[Console]::OutputEncoding = [System.Text.Encoding]::UTF8
[Console]::WriteLine($xml)