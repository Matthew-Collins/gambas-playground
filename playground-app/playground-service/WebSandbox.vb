Imports System.Net.Http

Public Class WebSandbox

    Public Property Host As New Uri("https://pg1.gambas.one/run.php")

    Public Async Function Run(Code As String) As Task(Of String)
        Dim Client As New HttpClient
        Dim Response = Await Client.PostAsync(Me.Host, New StringContent(Code))
        If Response.IsSuccessStatusCode Then
            Return (Await Response.Content.ReadAsStringAsync).Trim(vbLf)
        Else
            Return String.Empty
        End If
    End Function

End Class
