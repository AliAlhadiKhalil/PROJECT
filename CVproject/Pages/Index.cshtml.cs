using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using CVproject.Data;

namespace CVproject.Pages
{
    public class IndexModel : PageModel
    {
        private readonly CVproject.Data.ProjectContext _context;

        public IndexModel(CVproject.Data.ProjectContext context)
        {
            _context = context;
        }

        public IList<CV> CV { get;set; } = default!;

        public async Task OnGetAsync()
        {
            if (_context.cvs != null)
            {
                CV = await _context.cvs.ToListAsync();
            }
        }
    }
}
