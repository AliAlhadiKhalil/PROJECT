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
    public class DetailsModel : PageModel
    {
        private readonly CVproject.Data.ProjectContext _context;

        public DetailsModel(CVproject.Data.ProjectContext context)
        {
            _context = context;
        }

      public CV CV { get; set; } = default!; 

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null || _context.cvs == null)
            {
                return NotFound();
            }

            var cv = await _context.cvs.FirstOrDefaultAsync(m => m.Id == id);
            if (cv == null)
            {
                return NotFound();
            }
            else 
            {
                CV = cv;
            }
            return Page();
        }
    }
}
