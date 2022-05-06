Imports Microsoft.VisualStudio.TestTools.UnitTesting

<TestClass>
Public Class WebSandbox_Test

    <TestMethod>
    Public Sub TestPlaygroundViaWeb()
        Dim Sandbox As New playground_service.WebSandbox
        Dim Result As String = Sandbox.Run("Print ""Hello World""").Result
        Assert.AreEqual("Hello World", Result)
    End Sub

End Class
