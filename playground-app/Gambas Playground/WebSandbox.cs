using System;
using System.Net.Http;
using System.Threading.Tasks;
using Microsoft.VisualBasic;
using Microsoft.VisualBasic.CompilerServices;

namespace Gambas_Playground
{

    public class WebSandbox
    {

        public Uri Host { get; set; } = new Uri("https://pg1.gambas.one/run.php");

        public async Task<string> Run(string Code)
        {

            // Clean Line Endings
            Code = Code.Replace(Convert.ToString(Strings.Chr(13) + Strings.Chr(10)), Convert.ToString(Strings.Chr(10)));
            Code = Code.Replace(Strings.Chr(13), Strings.Chr(10));
            
            // Clean 66, 99 Quotes
            Code = Code.Replace(Strings.ChrW(8220), Strings.Chr(34));
            Code = Code.Replace(Strings.ChrW(8221), Strings.Chr(34));
            
            // Run Code in Web Sandbox
            var Client = new HttpClient();
            var Response = await Client.PostAsync(Host, new StringContent(Code));
            if (Response.IsSuccessStatusCode)
            {
                return (await Response.Content.ReadAsStringAsync()).Trim(Conversions.ToChar(Constants.vbLf));
            }
            else
            {
                return string.Empty;
            }

        }

    }
}