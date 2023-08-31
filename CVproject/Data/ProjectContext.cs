using Microsoft.EntityFrameworkCore;
using System;

namespace CVproject.Data
{
    public class ProjectContext : DbContext
    {
        public ProjectContext(DbContextOptions<ProjectContext> options) : base(options)
        {

        }
        public DbSet<CV> cvs { get; set; }
    }
}
